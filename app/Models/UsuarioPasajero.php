<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPasajero extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'usuario_pasajeros';
    protected $fillable = [
        'cedulaPasajero'
    ];

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'cedulaPasajero');
    }
}
