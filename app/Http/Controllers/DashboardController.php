<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siembra;
use App\Models\Cultivo;
use App\Models\Alerta;
use App\Models\VariableAmbiental;
use App\Models\EvaluacionRendimiento;
//use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        //dd(Auth::user()->id_tipo_usuario);
        $userId = auth()->id();

        // Estadísticas filtradas completamente por usuario
        $stats = [
            'totalSiembras'     => Siembra::where('user_id', $userId)->count(),
            'siembrasActivas'   => Siembra::where('user_id', $userId)
                                          ->where('estado_siembra_id', 1)
                                          ->count(),
            'totalCultivos'     => Cultivo::where('user_id', $userId)->count(),
            'alertasPendientes' => Alerta::whereHas('siembra', function($q) use ($userId) {
                                            $q->where('user_id', $userId);
                                        })
                                        ->where('leida', false)
                                        ->count(),
            'inversionTotal'    => Siembra::where('user_id', $userId)->sum('inversion'),
            'ingresosEstimados' => EvaluacionRendimiento::where('user_id', $userId)->sum('ingresos_estimados'),
        ];

        // Últimas siembras del usuario
        $siembrasRecientes = Siembra::where('user_id', $userId)
            ->with('cultivo')
            ->latest()
            ->take(5)
            ->get();

        // Últimas alertas asociadas a siembras del usuario
        $alertasRecientes = Alerta::whereHas('siembra', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->take(5)
            ->get();

        // Último monitoreo ambiental únicamente de siembras del usuario
        $ultimoMonitoreo = VariableAmbiental::whereHas('siembra', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest('fecha_hora')
            ->first();

        if (!$ultimoMonitoreo) {
            $ultimoMonitoreo = new VariableAmbiental([
                'temperatura'      => 0,
                'humedad'          => 0,
                'luminosidad_lux'  => 0,
                'ph_suelo'         => 0,
            ]);
        }
        $evaluacionesRecientes = EvaluacionRendimiento::with(['siembra.cultivo', 'user']) // Eager loading para optimizar
        ->latest('created_at') // O created_at
        ->take(4) // Muestra solo las últimas 4
        ->get();
        return view('dashboard', compact(
            'stats',
            'siembrasRecientes',
            'alertasRecientes',
            'ultimoMonitoreo',
            'evaluacionesRecientes'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
