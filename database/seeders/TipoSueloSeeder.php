<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSueloSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_suelos')->insert([
            ['nombre' => 'Tierra Fértil'],
            ['nombre' => 'Sustrato (Fibra de Coco/Perlita)'],
            ['nombre' => 'Hidropónico (Solución Nutritiva)'],
            ['nombre' => 'Invernadero Controlado'],
        ]);
    }
}