<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'cliente_id',
        'marca',
        'modelo',
        'anio',
        'placa',
        'combustible',
        'serie',
        'color',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function recepciones()
    {
        return $this->hasMany(Recepcion::class, 'vehiculo_id');
    }

    // Scope para filtros y orden
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            $query->where('placa', 'like', "%{$search}%")
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


    /*public function getRutaVistaCertificadoAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1: //tipo servicio = inicial gnv
                $ruta = route('certificadoInicialGnv', ['id' => $this->attributes['id']]);
                break;

            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }*/
}
