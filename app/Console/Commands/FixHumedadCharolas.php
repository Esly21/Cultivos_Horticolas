<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VariableAmbiental;

class FixHumedadCharolas extends Command
{
    protected $signature = 'fix:humedad-charolas';
    protected $description = 'Convierte valores crudos de humedad (0-1023) a porcentaje (0-100%)';

    public function handle()
    {
        $max = 1023;
        $total = VariableAmbiental::count();

        $this->info("Corrigiendo $total registros...");

        VariableAmbiental::chunk(100, function ($registros) use ($max) {
            foreach ($registros as $r) {

                // Solo convierte si el valor es > 100 (se asume RAW)
                if ($r->humedad_charola1 > 100) {
                    $r->humedad_charola1 = ($r->humedad_charola1 / $max) * 100;
                }
                if ($r->humedad_charola2 > 100) {
                    $r->humedad_charola2 = ($r->humedad_charola2 / $max) * 100;
                }
                if ($r->humedad_charola3 > 100) {
                    $r->humedad_charola3 = ($r->humedad_charola3 / $max) * 100;
                }
                if ($r->humedad_charola4 > 100) {
                    $r->humedad_charola4 = ($r->humedad_charola4 / $max) * 100;
                }

                $r->save();
            }
        });

        $this->info('✔ Conversión completada.');
        return 0;
    }
}
