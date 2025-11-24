<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EstadoSiembraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados_siembra')->insert([
            ['estado' => 'Activa'],
            ['estado' => 'En Cosecha'],
            ['estado' => 'Finalizada'],
            ['estado' => 'Cancelada'],
        ]);
    }
}
