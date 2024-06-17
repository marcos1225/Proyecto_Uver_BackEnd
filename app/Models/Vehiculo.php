<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'vehiculos';
    protected $fillable = [
        'matricula',
        'idMarca',
        'idModelo',
    ];

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'idModelo');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'idMarca');
    }
}
