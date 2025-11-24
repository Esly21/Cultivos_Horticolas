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
        $stats = [
            'totalSiembras' => Siembra::count(),
            'siembrasActivas' => Siembra::where('estado_siembra_id', 1)->count(), // Suponiendo ID 1 = Activa
            'totalCultivos' => Cultivo::count(),
            'alertasPendientes' => Alerta::where('leida', false)->count(),
            'inversionTotal' => Siembra::sum('inversion'),
            'ingresosEstimados' => 0, // Necesitarías una tabla de cosechas para esto
        ];
        $siembrasRecientes = Siembra::with('cultivo')->latest()->take(5)->get();
        $alertasRecientes = Alerta::latest()->take(5)->get();
        // Datos para el monitor ambiental (simplificado)
        $variablesAmbientales = VariableAmbiental::latest()->take(20)->get();

        return view('dashboard', compact('stats', 'siembrasRecientes', 'alertasRecientes', 'variablesAmbientales'));
    
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
