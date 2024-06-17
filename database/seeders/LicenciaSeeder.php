<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Licencia;

class LicenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Licencia::create([
            'tipo' => 'Licencia de conducir A', 
            'fechaVencimiento' => '2025-12-31', 
        ]);

        Licencia::create([
            'tipo' => 'Licencia de conducir B', 
            'fechaVencimiento' => '2026-06-30', 
        ]);

        Licencia::create([
            'tipo' => 'Licencia de conducir C', 
            'fechaVencimiento' => '2024-09-15', 
        ]);
    }

}
