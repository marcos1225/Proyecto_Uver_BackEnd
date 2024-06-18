<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Viaje;

class ViajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Viaje::create([
            'numeroPasajero' => 60906199,
            'numeroConductor' => 63549134,
            'UbicacionPasajero' => 'Ubicación inicial del pasajero',
            'UbicacionDestino' => 'Ubicación de destino',
            'estado' => '1',
        ]);
        
    }
}
