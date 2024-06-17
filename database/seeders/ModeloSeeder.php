<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modelo;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Modelo::create([
            'modelo' => 2021, 
        ]);

        Modelo::create([
            'modelo' => 2022, 
        ]);

        Modelo::create([
            'modelo' => 2023, 
        ]);
    }
}
