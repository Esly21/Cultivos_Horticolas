<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TipoSiembraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_siembra')->insert([
            ['nombre' => 'Directa', 'descripcion' => 'Semillas sembradas directamente en el sustrato definitivo.'],
            ['nombre' => 'Almácigo', 'descripcion' => 'Semillas sembradas en contenedores temporales para posterior trasplante.'],
            ['nombre' => 'Esqueje', 'descripcion' => 'Reproducción mediante fragmentos de tallos, hojas o raíces.'],
            ['nombre' => 'Hidropónica', 'descripcion' => 'Cultivo en soluciones minerales sin suelo agrícola.'],
        ]);
    }
}
