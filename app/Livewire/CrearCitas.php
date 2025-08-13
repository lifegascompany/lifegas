<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Cita;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CrearCitas extends Component
{
    public $open = false;

    // Datos del cliente
    public $nombre, $apellido, $documento, $telefono, $email, $direccion;

    // Datos del vehículo
    public $marca, $modelo, $anio, $placa, $combustible, $serie, $color;

    // Datos de la cita
    public $fecha_cita, $motivo;

    protected $listeners = ['abrirModalCita' => 'abrir'];

    protected $rules = [
        // Cliente
        'nombre'    => 'required|string|max:100',
        'apellido'  => 'required|string|max:100',
        'documento' => 'required|digits:8',
        'telefono'  => 'nullable|digits:9',
        'email'     => 'nullable|email|max:150',
        'direccion' => 'nullable|string|max:255',

        // Vehículo
        'marca'  => 'required|string|max:50',
        'modelo' => 'required|string|max:50',
        'anio'   => 'required|integer|min:1900|max:2100',
        'placa'  => 'required|string|size:6',
        'combustible'  => 'required|string|max:20',
        'serie'  => 'nullable|string|max:50',
        'color'  => 'nullable|string|max:50',

        // Cita
        'fecha_cita' => 'required|date|after_or_equal:today',
        'motivo'     => 'nullable|string|max:255',
    ];

    public function abrir()
    {
        $this->resetExcept('open');
        $this->open = true;
    }

    public function crearCita()
    {
        $this->validate();

        // 1️ Buscar o crear cliente
        $cliente = Cliente::firstOrCreate(
            // Busca por documento
            ['documento' => $this->documento],
            // Crea si no existe
            [
                'nombre'    => $this->nombre,
                'apellido'  => $this->apellido,
                'telefono'  => $this->telefono,
                'email'     => $this->email,
                'direccion' => $this->direccion,
            ]
        );

        // 2️ Crear vehículo
        /*$vehiculo = Vehiculo::create([
            'cliente_id' => $cliente->id,
            'marca'      => $this->marca,
            'modelo'     => $this->modelo,
            'anio'       => $this->anio,
            'placa'      => $this->placa,
            'combustible' => $this->combustible,
            'serie'      => $this->serie,
            'color'      => $this->color,
        ]);*/

        // 2️ Verificar si el vehículo ya existe por placa
        $vehiculoExistente = Vehiculo::where('placa', $this->placa)->first();
        if ($vehiculoExistente) {
            // Si el vehículo existe, asignarlo
            $vehiculo = $vehiculoExistente;
            // Opcional: Validar que pertenezca al mismo cliente
            if ($vehiculo->cliente_id != $cliente->id) {
                $this->dispatch('minAlert', titulo: "¡ERROR!", mensaje: "El vehiculo ingresado pertenece a otro cliente.", icono: "error");
                return;
            }
        } else {
            // Crear vehículo si no existe
            $vehiculo = Vehiculo::create([
                'cliente_id' => $cliente->id,
                'marca'      => $this->marca,
                'modelo'     => $this->modelo,
                'anio'       => $this->anio,
                'placa'      => $this->placa,
                'combustible' => $this->combustible,
                'serie'      => $this->serie,
                'color'      => $this->color,
            ]);
        }

        // 3️ Crear cita
        $cita = Cita::create([
            'cliente_id'  => $cliente->id,
            'vehiculo_id' => $vehiculo->id,
            'asesor_id'   => Auth::id(),
            'fecha_cita'  => $this->fecha_cita,
            'motivo'      => $this->motivo,
            'estado'      => 'pendiente',
        ]);

        // Limpiar formulario
        $this->reset();
        $fechaFormateada = Carbon::parse($cita->fecha_cita)->translatedFormat('l, d F Y');
        $this->dispatch('minAlert', titulo: "¡BUEN TRABAJO!", mensaje: "Se ha programado una cita para el " . $fechaFormateada, icono: "success");
        $this->dispatch('refrescarListaCitas');
    }

    public function render()
    {
        return view('livewire.crear-citas');
    }
}
