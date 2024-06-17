<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'licencias';
    protected $fillable = ['tipo', 'fechaVencimiento'];

    public function usuarioConductor()
    {
        return $this->hasOne(UsuarioConductor::class, 'idLicencia');
    }
}
