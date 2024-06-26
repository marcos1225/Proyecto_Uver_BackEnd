<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioConductor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'usuario_conductors';
    protected $fillable = [
        'numeroConductor',
        'idLicencia',
        'idVehiculo',
    ];

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'idLicencia');
    }
    public function vehiculo()
    {
        return $this->hasmany(Vehiculo::class, 'idVehiculo'); 
    }
}
