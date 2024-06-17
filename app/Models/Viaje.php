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
        'cedulaPasajero',
        'cedulaConductor',
        'UbicacionPasajero',
        'UbicacionDestino',
    ];

    public function pasajero()
    {
        return $this->belongsTo(UsuarioPasajero::class, 'cedulaPasajero');
    }
    public function conductor()
    {
        return $this->belongsTo(UsuarioConductor::class, 'cedulaConductor');
    }
}
