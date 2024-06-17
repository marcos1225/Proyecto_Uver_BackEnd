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
            'cedulaConductor' => '2222', 
            'idLicencia' => 3, 
            'vehiculo' => 'ABC123', 
        ]);

    }
}
