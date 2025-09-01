<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'cliente_id',
        'vehiculo_id',
        'asesor_id',
        'fecha_cita',
        'motivo',
        'estado', //enum('pendiente', 'aceptada', 'rechazada', 'cancelada')
    ];

    protected $casts = [
        'fecha_cita' => 'date', //datetime
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function expediente()
    {
        return $this->hasOne(Expediente::class, 'cita_id');
    }


    // Accesores

    // Scope para filtros y orden
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            $query->where('motivo', 'like', "%{$search}%")
                ->orWhereHas('cliente', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('documento', 'like', "%{$search}%");
                });
        }
    }

    public function scopeOrdenar($query, $sort, $direction)
    {
        return $query->orderBy($sort, $direction);
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado && $estado !== 'todos') {
            $query->where('estado', $estado);
        }
    }
}
