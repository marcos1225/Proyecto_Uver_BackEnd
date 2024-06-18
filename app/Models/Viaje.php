<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'viajes';
    protected $fillable = [
        'numeroPasajero',
        'numeroConductor',
        'UbicacionPasajero',
        'UbicacionDestino',
        'estado',
    ];

    public function pasajero()
    {
        return $this->belongsTo(UsuarioPasajero::class, 'numeroPasajero');
    }
    public function conductor()
    {
        return $this->belongsTo(UsuarioConductor::class, 'numeroConductor');
    }
    public function casts():array 
 {
    return [
        'estado' => 'boolean',
        
    ];
 }
}
