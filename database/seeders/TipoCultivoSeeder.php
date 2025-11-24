<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TipoCultivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_cultivo')->insert([
            ['nombre' => 'Hortaliza'],
            ['nombre' => 'Frutal'],
            ['nombre' => 'Aromática'],
            ['nombre' => 'Legumbre'],
        ]);
    }
}
