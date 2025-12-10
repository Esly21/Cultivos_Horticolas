<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluacionRendimiento;
use App\Models\Siembra;
use Carbon\Carbon;
use App\Models\TipoSuelo;
use App\Models\CalidadCosecha;

class EvaluacionController extends Controller
{
  public function index()
{
    $evaluaciones = EvaluacionRendimiento::with(['siembra', 'tipoSuelo', 'calidad'])
        ->orderBy('id', 'desc')
        ->paginate(10);  // ← AQUÍ EL CAMBIO

   $siembrasPendientes = Siembra::doesntHave('evaluacionRendimiento')
        ->with('cultivo')
        ->get();
    $tiposSuelo = TipoSuelo::all();
    $calidades = CalidadCosecha::all();

    return view('evaluaciones.index', compact('evaluaciones', 'siembrasPendientes', 'tiposSuelo', 'calidades'));
}
    
public function store(Request $request)
    {
        $request->validate([
            'siembra_id'         => 'required|exists:siembras,id',
            'tipo_suelo_id'      => 'required|exists:tipos_suelos,id',
            'fecha_cosecha_real' => 'required|date',
            'cantidad_cosechada' => 'required|numeric|min:0',
            'calidad_id'         => 'required|exists:calidad_cosechas,id',
            'tamano_promedio'    => 'required|string',
            'tipo_cosecha'       => 'required|string',
        ]);

        // Cálculo de días transcurridos desde la siembra
        $siembra = Siembra::find($request->siembra_id);
        $dias = Carbon::parse($siembra->fecha_siembra)->diffInDays(Carbon::now());

        EvaluacionRendimiento::create([
            'siembra_id'         => $request->siembra_id,
            'tipo_suelo_id'      => $request->tipo_suelo_id,
            'fecha_cosecha_real' => $request->fecha_cosecha_real,
            'cantidad_cosechada' => $request->cantidad_cosechada,
            'calidad_id'         => $request->calidad_id,
            'tamano_promedio'    => $request->tamano_promedio,
            'tipo_cosecha'       => $request->tipo_cosecha,
            'observaciones'      => $request->observaciones,
            'dias_transcurridos' => $dias,
        ]);

        return redirect()->back()->with('success', 'Evaluación registrada correctamente');
    }
    
}
