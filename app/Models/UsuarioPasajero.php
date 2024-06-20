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
        'numeroPasajero'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'numeroPasajero', 'numero');
    }

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'numeroPasajero');
    }
}
