<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expedientes';

    protected $fillable = [
        'cliente_id',
        'vehiculo_id',
        'cita_id',
        'estado',
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

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentosExpediente::class, 'expediente_id');
    }

    // Scope para filtros y orden
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%");
            });
            }
    }

    public function scopeOrdenar($query, $sort, $direction)
    {
        return $query->orderBy($sort, $direction);
    }
}
