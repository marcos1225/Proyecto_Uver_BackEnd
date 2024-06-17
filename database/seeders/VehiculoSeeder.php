<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Vehiculo::create([
            'matricula' => 'ABC123', 
            'idMarca' => 1, 
            'idModelo' => 1, 
        ]);

        Vehiculo::create([
            'matricula' => 'XYZ789', 
            'idMarca' => 2, 
            'idModelo' => 2, 
        ]);

      
    }
}
