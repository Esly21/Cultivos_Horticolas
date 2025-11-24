<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Siembra;
use App\Models\VariableAmbiental;
use App\Models\Bitacora;
use Carbon\Carbon;

class GenerarReporteSemanal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportes:generar-semanal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un resumen semanal del estado de todas las siembras activas.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando la generación de reportes semanales...');

        // 1. Obtenemos todas las siembras que están activas
        $siembrasActivas = Siembra::where('estado_siembra_id', 1)->get(); // Asume 1 = Activa

        if ($siembrasActivas->isEmpty()) {
            $this->info('No hay siembras activas. No se generaron reportes.');
            return 0; // Termina el comando
        }

        foreach ($siembrasActivas as $siembra) {
            // 2. Para cada siembra, obtenemos los datos de la última semana
            $datosSemana = VariableAmbiental::where('siembra_id', $siembra->id)
                ->whereBetween('fecha_hora', [Carbon::now()->subDays(7), Carbon::now()])
                ->get();

            if ($datosSemana->isEmpty()) {
                continue; // Si no hay datos, pasa a la siguiente siembra
            }

            // 3. Calculamos las estadísticas de la semana
            $tempPromedio = $datosSemana->avg('temperatura');
            $humPromedio = $datosSemana->avg('humedad');
            $tempMax = $datosSemana->max('temperatura');
            $tempMin = $datosSemana->min('temperatura');

            // 4. Creamos el texto del reporte
            $observaciones = "Resumen semanal automático:\n" .
                             "- Temperatura promedio: " . number_format($tempPromedio, 1) . "°C\n" .
                             "- Humedad promedio: " . number_format($humPromedio, 1) . "%\n" .
                             "- Rango de temperatura: " . number_format($tempMin, 1) . "°C a " . number_format($tempMax, 1) . "°C.\n" .
                             "El cultivo se mantuvo estable durante la semana.";

            // 5. Guardamos el nuevo reporte (Bitácora) en la base de datos
            Bitacora::create([
                'siembra_id' => $siembra->id,
                'fecha_seguimiento' => now(),
                'observaciones' => $observaciones,
                'crecimiento' => 'Seguimiento Automático', // Para diferenciarlo de los manuales
                'temperatura_actual' => $tempPromedio,
                'humedad_actual' => $humPromedio,
            ]);

            $this->info("Reporte generado para la siembra #{$siembra->id}.");
        }

        $this->info('¡Reportes semanales generados exitosamente!');
        return 0;
    }
}
