<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siembra;
use App\Models\Cultivo;
use App\Models\Alerta;
use App\Models\VariableAmbiental;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'totalSiembras'    => Siembra::where('user_id', $userId)->count(),
            'siembrasActivas'  => Siembra::where('user_id', $userId)
                                         ->where('estado_siembra_id', 1)->count(),
            'totalCultivos'    => Cultivo::count(), // si cultivos son globales, dejar así; si no, filtra por user
            'alertasPendientes'=> Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
                                       ->where('leida', false)->count(),
            'inversionTotal'   => Siembra::where('user_id', $userId)->sum('inversion'),
            'ingresosEstimados'=> 0,
        ];

        $siembrasRecientes = Siembra::where('user_id', $userId)
            ->with('cultivo')
            ->latest()
            ->take(5)
            ->get();

        $alertasRecientes = Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
            ->latest()
            ->take(5)
            ->get();

        $ultimoMonitoreo = VariableAmbiental::latest('fecha_hora')->first();
        if (!$ultimoMonitoreo) {
            $ultimoMonitoreo = new VariableAmbiental([
                'temperatura'       => 0,
                'humedad'           => 0,
                'luminosidad_lux'   => 0,
                'ph_suelo'          => 0,
            ]);
        }

        return view('dashboard', compact(
            'stats',
            'siembrasRecientes',
            'alertasRecientes',
            'ultimoMonitoreo'
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
