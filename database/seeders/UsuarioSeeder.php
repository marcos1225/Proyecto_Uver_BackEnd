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
            'numero' => 63549134,
            'nombre' => 'Marcos',
            'apellido' => 'Gonzalez',
            'clave' => bcrypt('patitos123'),
        ]);
        Usuario::create([
            'cedula' => '2222',
            'numero' => 60906199,
            'nombre' => 'Maria',
            'apellido' => 'Navarrete',
            'clave' => bcrypt('pollitos123'),
        ]);
       
        
    }
}
