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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function recepciones()
    {
        return $this->hasMany(Recepcion::class, 'vehiculo_id');
    }
}
