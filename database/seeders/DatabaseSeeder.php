<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TipoUsuarioSeeder::class,
            TipoCultivoSeeder::class,
            EstadoSiembraSeeder::class,
            CalidadCosechaSeeder::class, 
            TipoSueloSeeder::class,
            TipoSiembraSeeder::class,
            DimensionSeeder::class,
            RangoSeeder::class,
            PeriodoSeeder::class,
        ]);

        //User::factory()->create([
            //'name' => 'Test User',
            //'email' => 'test@example.com',
        //]);
    }
}
