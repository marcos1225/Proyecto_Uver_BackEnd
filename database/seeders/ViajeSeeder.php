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
            'cedulaPasajero' => '1234567890',
            'cedulaConductor' => '2222',
            'UbicacionPasajero' => 'Ubicación inicial del pasajero',
            'UbicacionDestino' => 'Ubicación de destino',
            'estado' => '1',
        ]);
        
    }
}
