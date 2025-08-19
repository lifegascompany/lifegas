<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $table = 'conversiones';

    protected $fillable = [
        'expediente_id',
        'tecnico_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones',
    ];

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function controlCalidad()
    {
        return $this->hasMany(ControlCalidad::class, 'conversion_id');
    }

    /*public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }*/
}
