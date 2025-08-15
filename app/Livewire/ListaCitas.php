<?php

namespace App\Livewire;

use App\Models\Cita;
use App\Models\Expediente;
use App\Models\FiseSolicitud;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListaCitas extends Component
{
    use WithPagination;
    public $sort,$order,$cant,$search,$direction, $open;

    public function mount(){
      $this->direction='desc';
      $this->sort='id';       
      $this->cant=10;
      $this->open=false;
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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Marca el método con el atributo #[On] para que escuche los eventos.
    #[On('refrescarListaCitas')]
    public function actualizarListaCitas()
    {
        // No es necesario escribir código aquí.
        // Livewire sabe que, al ejecutarse este método, debe renderizar la vista.
        // La lógica de paginación en el método render() se encargará de refrescar la lista.
    }

    #[On('marcarCitaComoRechazada')]
    public function marcarCitaComoRechazada($id)
    {
        $cita = Cita::with(['cliente', 'vehiculo'])->findOrFail($id);
        if ($cita) {
            $cita->estado = 'rechazada';
            $cita->save();
        }
        $this->dispatch('citaRechazada');
    }

    #[On('marcarCitaComoAceptada')]
    public function marcarCitaComoAceptada($id)
    {
        $cita = Cita::with(['cliente', 'vehiculo'])->findOrFail($id);

        if ($cita) {
            // Cambiar estado de la cita
            $cita->estado = 'aceptada';
            $cita->save();

            // Crear expediente solo si no existe
            $expedienteExiste = Expediente::where('cita_id', $cita->id)->exists();
            if (!$expedienteExiste) {
                Expediente::create([
                    'cliente_id'  => $cita->cliente_id,
                    'vehiculo_id' => $cita->vehiculo_id,
                    'cita_id'     => $cita->id,
                    'estado'      => 1,
                ]);
            }

            // Crear solicitud FISE solo si no existe
            $fiseExiste = FiseSolicitud::where('cliente_id', $cita->cliente_id)
                ->where('vehiculo_id', $cita->vehiculo_id)
                ->exists();

            if (!$fiseExiste) {
                FiseSolicitud::create([
                    'cliente_id'     => $cita->cliente_id,
                    'vehiculo_id'    => $cita->vehiculo_id,
                    'fecha_solicitud'=> now(),
                    'estado'         => 'pendiente',
                    'observaciones'  => null,
                ]);
            }
        }

        $this->dispatch('citaAceptada');
    }

    public function render()
    {
        $citas = Cita::with(['cliente', 'vehiculo', 'asesor'])
            ->buscar($this->search)
            ->ordenar($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.lista-citas', compact('citas'));
    }
}
