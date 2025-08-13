<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCalidad extends Model
{
    use HasFactory;

    protected $table = 'control_calidad';

    protected $fillable = [
        'conversion_id',
        'jefe_taller_id',
        'fecha_control',
        'resultado',
        'observaciones',
    ];

    public function conversion()
    {
        return $this->belongsTo(Conversion::class, 'conversion_id');
    }

    public function jefeTaller()
    {
        return $this->belongsTo(User::class, 'jefe_taller_id');
    }
}
