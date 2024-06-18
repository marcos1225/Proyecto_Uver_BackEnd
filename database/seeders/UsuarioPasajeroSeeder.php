<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UsuarioPasajero;

class UsuarioPasajeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        UsuarioPasajero::create([
            'numeroPasajero' => 60906199, // Ajusta según tus necesidades
        ]);
        
    }
}
