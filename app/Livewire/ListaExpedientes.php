<?php

namespace App\Livewire;

use App\Models\DocumentosExpediente;
use App\Models\Expediente;
use App\Models\TiposDocumento;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class ListaExpedientes extends Component
{
    use WithPagination, WithFileUploads;
    public $sort, $order, $cant, $search, $direction;

    public $open = false;
    public $expedienteSeleccionado;

    /** Documentos existentes del expediente (colección) */
    public $files = [];

    /** Carga nueva (múltiples archivos) */
    public $documentoNuevo = [];

    /** Tipo seleccionado para los archivos nuevos */
    public $tipo_documento_id = '';

    /** Catálogo de tipos */
    public $tiposDocumentos;

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
        $this->open = true;
    }

    public function subirDocumento()
    {
        // Validar subida múltiple
        $this->validate();

        if (!$this->expedienteSeleccionado) {
            return;
        }

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
        $this->resetErrorBag();
        $this->resetValidation();
    }

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

    public function deleteFileUpload($key)
    {
        if (isset($this->documentoNuevo[$key])) {
            unset($this->documentoNuevo[$key]);
            $this->documentoNuevo = array_values($this->documentoNuevo); // reindexar
        }
    }

    public function render()
    {
        $expedientes = Expediente::with(['cliente', 'vehiculo', 'cita'])
            ->buscar($this->search)
            ->ordenar($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.lista-expedientes', compact('expedientes'));
    }
}
