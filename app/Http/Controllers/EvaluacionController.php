<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Cultivo;
use App\Models\Siembra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class EvaluacionController extends Controller
{
    /* =====================================================
     | INDEX
     ===================================================== */
    public function index()
    {
        $userId = Auth::id();

        return view('evaluaciones.index', [
            'cultivos' => Cultivo::where('user_id', $userId)->get(),
            'siembras' => Siembra::with('cultivo')
                ->where('user_id', $userId)
                ->get(),
            'evaluaciones' => Evaluacion::with('cultivo')
                ->where('user_id', $userId)
                ->latest()
                ->get(), // NO paginate (tabs)
        ]);
    }

    /* =====================================================
     | CALCULAR (AJAX)
     ===================================================== */
    public function calcular(Request $request)
    {
        $request->validate([
            'siembras'   => 'required|array|min:2',
            'siembras.*' => 'exists:siembras,id',
        ]);

        $siembras = Siembra::with([
                'cultivo',
                'cosechas.calidad',
                'variablesAmbientales'
            ])
            ->whereIn('id', $request->siembras)
            ->where('user_id', Auth::id())
            ->get();

        $detalle = [];

        foreach ($siembras as $s) {

            $ingresos = $s->cosechas->sum('ingresos_estimados');
            $cantidad = $s->cosechas->sum('cantidad_cosechada');
            $inversion = $s->inversion ?? 0;
            $rentabilidad = $ingresos - $inversion;

            $ultimaCosecha = $s->cosechas->last();
            $fechaCosecha = $ultimaCosecha?->fecha_cosecha_real;

            $calidad = 'N/A';
            if ($ultimaCosecha && $ultimaCosecha->calidad) {
                $calidad = $ultimaCosecha->calidad->nombre
                    ?? $ultimaCosecha->calidad->calidad
                    ?? 'N/A';
            }

            $temp = $s->variablesAmbientales->count()
                ? round($s->variablesAmbientales->avg('temperatura'), 1)
                : 0;

            $hum = $s->variablesAmbientales->count()
                ? round($s->variablesAmbientales->avg('humedad'), 1)
                : 0;

            $dias = 0;
            if ($s->fecha_inicio) {
                $inicio = $s->fecha_inicio;
                $fin = $fechaCosecha ?? now();
                $dias = $inicio->diffInDays($fin);
            }

            $nombreCultivo = $s->cultivo?->nombre_comun ?? 'Siembra';
            $fechaInicio = $s->fecha_inicio?->format('d/m') ?? '';
            $label = "{$nombreCultivo} ({$fechaInicio})";

            $detalle[] = [
                'siembra_id'   => $s->id,
                'label'        => $label,
                'inversion'    => (float) $inversion,
                'ingresos'     => (float) $ingresos,
                'rentabilidad' => (float) $rentabilidad,
                'cantidad'     => (float) $cantidad,
                'temperatura'  => (float) $temp,
                'humedad'      => (float) $hum,
                'calidad'      => $calidad,
                'dias'         => $dias,
            ];
        }

        $col = collect($detalle);

        return response()->json([
            'resumen' => [
                'inversion_promedio' => round($col->avg('inversion'), 2),
                'ingresos_promedio'  => round($col->avg('ingresos'), 2),
                'cantidad_promedio'  => round($col->avg('cantidad'), 2),
                'temperatura'        => round($col->avg('temperatura'), 1),
                'humedad'            => round($col->avg('humedad'), 1),
            ],
            'detalle' => $detalle,
        ]);
    }

    /* =====================================================
     | STORE
     ===================================================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:150',
            'cultivo_id'   => 'required|exists:cultivos,id',
            'siembras_ids' => 'required|array|min:2',
            'resultado'    => 'required|array',
            'notas'        => 'nullable|string',
        ]);

        $evaluacion = Evaluacion::create([
            'user_id'      => Auth::id(),
            'cultivo_id'   => $validated['cultivo_id'],
            'nombre'       => $validated['nombre'],
            'notas'        => $validated['notas'] ?? null,
            'siembras_ids' => $validated['siembras_ids'],
            'resultado'    => $validated['resultado'],
        ]);

        return response()->json([
            'message' => 'Evaluación guardada correctamente',
            'id'      => $evaluacion->id,
        ]);
    }

    /* =====================================================
     | EXPORTAR PDF
     ===================================================== */
public function exportarPdf(Request $request, $id)
{
    try {
        // 1. Cargar evaluación con relaciones necesarias
        $evaluacion = Evaluacion::with('cultivo', 'user')->findOrFail($id);

        // 2. Extraer resumen y detalle del resultado JSON
        $resultado = $evaluacion->resultado ?? [];
        $resumen = $resultado['resumen'] ?? [];
        $detalle = $resultado['detalle'] ?? [];

        // 3. Procesar imágenes Base64
        $chartsBase64 = array_filter($request->only([
            'ingresos', 'rentabilidad', 'cantidad', 'temperatura', 'humedad',
        ]));
        $charts = [];

        foreach ($chartsBase64 as $key => $base64) {
            if (str_starts_with($base64, 'data:image')) {
                [, $data] = explode(',', $base64);
            } else {
                $data = $base64;
            }

            $imageData = base64_decode($data);
            if ($imageData === false) {
                throw new \Exception("Error decodificando imagen Base64 para {$key}");
            }

            $charts[$key] = 'data:image/png;base64,' . base64_encode($imageData);
        }
        // 4. Generar PDF
        $pdf = Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ])->loadView('evaluaciones.pdf', [
            'evaluacion' => $evaluacion,
            'usuario' => $evaluacion->user,
            'resumen' => $resumen,
            'detalle' => $detalle,
            'charts' => $charts, // YA ESTÁ AQUÍ, CONFIRMA QUE NO LO BORRES
        ]);

        // 5. Descargar
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Evaluacion_' . $evaluacion->nombre . '.pdf');

    } catch (\Exception $e) {
        \Log::error('Error generando PDF: ' . $e->getMessage());
        return response()->json(['error' => 'Error generando el PDF: ' . $e->getMessage()], 500);
    }
}
    /* =====================================================
     | HISTÓRICO (opcional)
     ===================================================== */
    public function historico()
    {
        $evaluaciones = Evaluacion::with('cultivo')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('evaluaciones.historico', compact('evaluaciones'));
    }
}
