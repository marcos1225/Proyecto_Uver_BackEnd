<?php

namespace Database\Seeders;


use App\Models\Vehiculo;
use App\Models\Viaje;
use App\Models\UsuarioConductor;
use App\Models\UsuarioPasajero;
use App\Models\Usuario;
use App\Models\Licencia;
use App\Models\Marca;
use App\Models\Modelo;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            UsuarioPasajeroSeeder::class,
            LicenciaSeeder::class,
            MarcaSeeder::class,
            ModeloSeeder::class,
            VehiculoSeeder::class,
            UsuarioConductorSeeder::class,
            ViajeSeeder::class,
        ]);

       
    }
}
