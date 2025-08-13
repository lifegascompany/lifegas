<?php

namespace App\Livewire;

use App\Models\Cita;
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

    // Marca el método con el atributo #[On] para que escuche el evento 'refrescarListaCitas'
    #[On('refrescarListaCitas')]
    public function actualizarListaCitas()
    {
        // No es necesario escribir código aquí.
        // Livewire sabe que, al ejecutarse este método, debe renderizar la vista.
        // La lógica de paginación en el método render() se encargará de refrescar la lista.
    }

    public function marcarAceptada($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'aceptada';
        $cita->save();

        // Redirigir a la creación de expediente
        //return redirect()->route('expedientes.create', ['cita' => $cita->id]);
    }

    public function marcarRechazada($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'rechazada';
        $cita->save();

        $this->dispatch('refrescarListaCitas');
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
