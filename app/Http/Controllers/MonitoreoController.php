<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siembra;
use App\Models\VariableAmbiental;
use Carbon\Carbon;
class MonitoreoController extends Controller
{   /**
     * Muestra el listado de siembras activas con su última lectura.
     */
    public function index()
    {
        $siembras = Siembra::where('user_id', auth()->id())
            ->where('estado_siembra_id', 1)
            ->with('ultimaLectura')
            ->get();

        return view('monitoreo.index', compact('siembras'));
    }

    /**
     * Devuelve la última lectura de una siembra en formato JSON.
     */
    public function getLatestData(Siembra $siembra)
    {
        $latestData = VariableAmbiental::where('siembra_id', $siembra->id)
            ->latest('fecha_hora')
            ->first();

        if ($latestData) {
            return response()->json([
                'temperatura'        => $latestData->temperatura,
                'humedad'            => $latestData->humedad,
                'ph_suelo'           => $latestData->ph_suelo,
                'luminosidad_lux'    => $latestData->luminosidad_lux,
                'humedad_charola1'   => $latestData->humedad_charola1,
                'humedad_charola2'   => $latestData->humedad_charola2,
                'humedad_charola3'   => $latestData->humedad_charola3,
                'humedad_charola4'   => $latestData->humedad_charola4,
                'ventilador_activo'  => $latestData->ventilador_activo,
                'riego_activo'       => $latestData->riego_activo,
                'fecha_hora'         => $latestData->fecha_hora?->format('Y-m-d H:i:s'),
            ]);
        }

        return response()->json([
            'temperatura'        => 0,
            'humedad'            => 0,
            'ph_suelo'           => 0,
            'luminosidad_lux'    => 0 , 	 	 	 	
            'humedad_charola1'   => 0,
            'humedad_charola2'   => 0,
            'humedad_charola3'   => 0,
            'humedad_charola4'   => 0,
            'ventilador_activo'  => false,
            'riego_activo'       => false,
            'fecha_hora'         => null,
        ]);
    }

    /**
     * Devuelve datos históricos para la gráfica.
     */
    public function getHistoricos(Siembra $siembra, Request $request)
    {
        $hours = $request->query('hours', 24);

        $fechaDesde = now()->subHours($hours);

        $datos = VariableAmbiental::where('siembra_id', $siembra->id)
            ->where('fecha_hora', '>=', $fechaDesde)
            ->orderBy('fecha_hora')
            ->get([
                'fecha_hora',
                'temperatura',
                'humedad',
                'luminosidad_lux',
                'ph_suelo',
                'humedad_charola1',
                'humedad_charola2',
                'humedad_charola3',
                'humedad_charola4',
                'ventilador_activo',
                'riego_activo',
            ]);

        return response()->json($datos);
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