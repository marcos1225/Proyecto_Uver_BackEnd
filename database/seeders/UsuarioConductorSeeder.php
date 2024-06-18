<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UsuarioConductor;

class UsuarioConductorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        UsuarioConductor::create([
            'numeroConductor' => 63549134, 
            'idLicencia' => 3, 
            'idVehiculo' => 'ABC123', 
        ]);

    }
}
