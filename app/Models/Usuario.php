<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'usuarios';
    protected $fillable = ['cedula','numero','nombre','apellido','clave'];

    public function pasajero()
    {
        return $this->hasOne(UsuarioPasajero::class, 'cedulaPasajero', 'cedula');
    }

    public function conductor()
    {
        return $this->hasOne(UsuarioConductor::class, 'cedulaConductor', 'cedula');
    }
}
