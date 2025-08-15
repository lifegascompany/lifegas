<?php

namespace App\Livewire;

use App\Models\Vehiculo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListaVehiculos extends Component
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


    public function render()
    {
        $vehiculos = Vehiculo::with(['cliente', 'recepciones'])
            ->buscar($this->search)
            ->ordenar($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.lista-vehiculos', compact('vehiculos'));
    }
}
