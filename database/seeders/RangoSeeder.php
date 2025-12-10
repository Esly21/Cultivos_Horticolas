<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  
class RangoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rangos')->insert([
            ['nombre' => 'Temperatura: 15-20°C, Humedad: 50-60%'],
            ['nombre' => 'Temperatura: 20-25°C, Humedad: 60-70%'],
            ['nombre' => 'Temperatura: 25-30°C, Humedad: 70-80%'],
            ['nombre' => 'Temperatura: >30°C, Humedad: >80%'],
        ]);
    }
}
