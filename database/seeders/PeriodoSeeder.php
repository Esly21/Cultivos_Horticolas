<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('periodos')->insert([
            ['nombre' => 'Ciclo Corto (30-50 días)'],
            ['nombre' => 'Ciclo Medio (50-70 días)'],
            ['nombre' => 'Ciclo Largo (70-90 días)'],
            ['nombre' => 'Ciclo Extenso (90-120 días)'],
        ]);
    }
}
