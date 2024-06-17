<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'modelos';
    protected $fillable = ['modelo'];
    
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'idModelo');
    }
}
