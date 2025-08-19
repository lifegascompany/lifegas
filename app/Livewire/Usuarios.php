<?php

namespace App\Livewire;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Usuarios extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Listado
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    public $search = '';

    public $selectedRoles = [];
    public $roles;

    public $editando = false;

    public $name, $email;

    public $usuario;

    protected $messages = [
        'selectedRoles.min' => 'Debes seleccionar como mínimo un rol para este usuario.',
    ];

    protected $rules = [
        "name" => "required|string",
        "email" => "required|email",
        "selectedRoles" => "array|min:1",
    ];

    public function updated($propertyName)
    {

        $this->validateOnly($propertyName);
    }

    public function order($sort)
    {
        if ($this->sort === $sort) {
            $this->direction = $this->direction === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $usuarios = User::where([
                ['id', '!=', Auth::id()],
                ['name', 'like', '%' . $this->search . '%']
            ])
            ->orWhere([
                ['id', '!=', Auth::id()],
                ['email', 'like', '%' . $this->search . '%']
            ])
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        return view('livewire.usuarios', compact('usuarios'));
    }

    public function editarUsuario(User $usuario)
    {
        $this->usuario = $usuario;
        $this->roles = Roles::all();
        $this->selectedRoles = $usuario->roles->pluck('name')->all();

        // Pasar los valores actuales a los inputs del modal
        $this->name = $usuario->name;
        $this->email = $usuario->email;

        $this->editando = true;
    }

    public function actualizar()
    {
        $this->validate();

        // Asignar cambios
        $this->usuario->name = $this->name;
        $this->usuario->email = $this->email;

        // Actualizar roles
        $this->usuario->syncRoles($this->selectedRoles);

        $this->usuario->save();

        // Limpiar
        $this->reset(["editando", "name", "email", "selectedRoles", "usuario"]);

        $this->dispatch(
            'minAlert',
            titulo: "¡BUEN TRABAJO!",
            mensaje: "Se actualizaron los datos de usuario correctamente.",
            icono: "success"
        );
    }
}
