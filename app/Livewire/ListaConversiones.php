<?php

namespace App\Livewire;

use App\Models\Conversion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListaConversiones extends Component
{
    use WithPagination;
    public $sort, $order, $cant, $search, $direction, $es;

    // Método para escuchar el evento 'refreshList' de otros componentes
    #[On('refreshList')]
    public function refresh()
    {
        //$this->render();
        // Se actualiza la vista, que es lo que se quiere lograr.
        // No es necesario llamar a render() aquí, Livewire se encarga automáticamente.
    }

    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
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

    //Redirecciona a la página de SolicitudRepuestos con el ID de la conversión.
    public function redirectToSolicitudRepuestos($conversionId)
    {
        // Usamos la función de redirección de Livewire para ir a la nueva ruta
        // con el ID de la conversión.
        return redirect()->route('SolicitudRepuestos', ['conversionId' => $conversionId]);
    }
    public function render()
    {
        $conversiones = Conversion::with(['expediente', 'tecnico'])
            ->buscar($this->search)
            ->estado($this->es)
            ->ordenar($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.lista-conversiones', compact('conversiones'));
    }
}
