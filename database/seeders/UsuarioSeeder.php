<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Usuario::create([
            'cedula' => '1234567890',
            'numero' => '187472323',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'clave' => 'password',
        ]);
        Usuario::create([
            'cedula' => '2222',
            'numero' => '187472323',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'clave' => 'password',
        ]);
        
    }
}
