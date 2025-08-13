<?php

namespace App\Livewire;

use App\Models\Roles;
use Livewire\Component;

class ListaRoles extends Component
{
    public $roles;

    public function mount(){
        $this->roles=Roles::all();
    }

    public function render()
    {
        return view('livewire.lista-roles');
    }
}
