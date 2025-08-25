<?php

namespace App\Livewire;

use App\Models\DocumentosExpediente;
use App\Models\Expediente;
use App\Models\TiposDocumento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class ListaExpedientes extends Component
{
    use WithPagination, WithFileUploads;
    public $sort, $order, $cant, $search, $direction, $es;
    // Para el modal
    public $open = false, $expedienteSeleccionado;
    // Documentos existentes del expediente
    public $files = [];
    // Carga nueva (múltiples archivos) 
    public $documentoNuevo = [];
    // Tipo seleccionado para los archivos nuevos 
    public $tipo_documento_id = '';
    // Catálogo de tipos
    public $tiposDocumentos, $tecnicos;
    // Técnico asignado
    public $tecnico_id = '';
    // Carga el usuario autenticado
    public $user;

    protected $rules = [
        'tipo_documento_id'     => 'required|exists:tipos_documento,id',
        'documentoNuevo'        => 'required|array|min:1',
        'documentoNuevo.*'      => 'file|max:2048|mimes:jpg,jpeg,png,gif,bmp,tif,tiff',
    ];

    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
        $this->tiposDocumentos = TiposDocumento::all();
        $this->tecnicos = User::role(['Tecnico'])->orderBy('name')->get();
        $this->user = Auth::user();
        //dd($this->user);
    }

    public function order($sort)
    {
        if ($this->sort === $sort) {
            $this->direction = $this->direction === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function verExpediente($id)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['documentoNuevo', 'tipo_documento_id']);

        $this->expedienteSeleccionado = Expediente::with(['cliente', 'vehiculo', 'cita.asesor', 'documentos.tipoDocumento'])
            ->findOrFail($id);

        $this->files = $this->expedienteSeleccionado->documentos; // documentos existentes
        $this->tecnico_id = $this->expedienteSeleccionado->tecnico_id;
        $this->open = true;
    }

    public function asignarTecnico()
    {
        if (!$this->expedienteSeleccionado) {
            return;
        }

        $this->expedienteSeleccionado->update([
            'tecnico_id' => $this->tecnico_id,
        ]);

        $this->dispatch('minAlert', titulo: "¡BUEN TRABAJO!", mensaje: "Técnico asignado correctamente", icono: "success");
    }

    public function subirDocumento()
    {
        if (!$this->expedienteSeleccionado) {
            return;
        }

        // Asignar técnico aunque no se suban archivos
        $this->expedienteSeleccionado->update([
            'tecnico_id' => $this->tecnico_id,
        ]);

        // Subida de documentos SOLO si hay archivos
        if (!empty($this->documentoNuevo)) {
            $this->validate([
                'tipo_documento_id'     => 'required|exists:tipos_documento,id',
                'documentoNuevo'        => 'required|array|min:1',
                'documentoNuevo.*'      => 'file|max:2048|mimes:jpg,jpeg,png,gif,bmp,tif,tiff',
            ]);

            // Guardar cada archivo
            foreach ($this->documentoNuevo as $archivo) {
                // Sugerencia: guardar en subcarpeta por expediente
                $path = $archivo->store('expedientes/' . $this->expedienteSeleccionado->id, 'public');

                DocumentosExpediente::create([
                    'expediente_id'     => $this->expedienteSeleccionado->id,
                    'tipo_documento_id' => $this->tipo_documento_id,
                    'nombre'            => $archivo->getClientOriginalName(),
                    'ruta'              => '/storage/' . $path,
                    'extension'         => $archivo->getClientOriginalExtension(),
                ]);
            }

            // Refrescar vista
            $this->expedienteSeleccionado->load('documentos.tipoDocumento');
            $this->files = $this->expedienteSeleccionado->documentos;

            // Limpiar inputs
            $this->reset(['documentoNuevo', 'tipo_documento_id']);
        }

        $this->resetErrorBag();
        $this->resetValidation();
        $this->open = false;
        $this->dispatch('minAlert', titulo: "¡BUEN TRABAJO!", mensaje: "Se guardaron los cambios correctamente", icono: "success");
    }

    // Eliminar archivo de la BD y del disco
    public function deleteFile(int $id)
    {
        if (!$this->expedienteSeleccionado) return;

        $doc = DocumentosExpediente::where('id', $id)
            ->where('expediente_id', $this->expedienteSeleccionado->id)
            ->first();

        if (!$doc) return;

        // Eliminar del disco
        $relative = Str::after($doc->ruta, '/storage/');
        Storage::disk('public')->delete($relative);

        // Eliminar DB
        $doc->delete();

        // Refrescar lista
        $this->expedienteSeleccionado->load('documentos.tipoDocumento');
        $this->files = $this->expedienteSeleccionado->documentos;
    }

    // Eliminar archivo de carga nueva
    public function deleteFileUpload($key)
    {
        if (isset($this->documentoNuevo[$key])) {
            unset($this->documentoNuevo[$key]);
            $this->documentoNuevo = array_values($this->documentoNuevo); // reindexar
        }
    }

    // Muestra los expedientes con filtros y orden
    public function render()
    {
        $expedientes = Expediente::with(['cliente', 'vehiculo', 'cita'])
            ->buscar($this->search)
            ->estado($this->es)
            ->when($this->user->hasRole('Tecnico'), function ($q) {
                $q->where('tecnico_id', $this->user->id);
            })
            ->ordenar($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.lista-expedientes', compact('expedientes'));
    }
}
