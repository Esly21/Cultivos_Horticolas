<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dimensiones')->insert([
            ['altura' => 10.00, 'ancho' => 30.00, 'largo' => 50.00], // Charola pequeña
            ['altura' => 15.00, 'ancho' => 40.00, 'largo' => 60.00], // Charola mediana
            ['altura' => 20.00, 'ancho' => 50.00, 'largo' => 100.00], // Mesa de cultivo
            ['altura' => 5.00, 'ancho' => 25.00, 'largo' => 40.00], // Semillero
        ]);
    }
}
