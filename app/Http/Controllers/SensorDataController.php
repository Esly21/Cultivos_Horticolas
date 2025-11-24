<?php

namespace App\Http\Controllers;

use App\Models\VariableAmbiental;
use Illuminate\Http\Request;
use App\Models\Alerta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
    Log::info('Datos recibidos del ESP8266:', $request->all());

        // 1. Validamos los campos que SÍ envía el ESP 
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|exists:siembras,id',
            'temperatura' => 'required|numeric',
            'humedad_ambiente' => 'required|numeric',
            'luz' => 'nullable|numeric',
            'humedad_suelo.zona1' => 'nullable|numeric',
            'humedad_suelo.zona2' => 'nullable|numeric',
            'humedad_suelo.zona3' => 'nullable|numeric',
            'humedad_suelo.zona4' => 'nullable|numeric',
            'actuadores.ventilador' => 'nullable|boolean',
            'actuadores.riego_activo' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            Log::error('Fallo la validación del ESP8266:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. "Traducimos" los nombres y guardamos en la BD
        try {
            VariableAmbiental::create([
                'siembra_id' => $request->device_id,
                'temperatura' => $request->temperatura,
                'humedad' => $request->humedad_ambiente,
                'luminosidad_lux' => $request->luz,
                
                // Mapeamos el JSON anidado 
                'humedad_charola1' => $request->input('humedad_suelo.zona1'),
                'humedad_charola2' => $request->input('humedad_suelo.zona2'),
                'humedad_charola3' => $request->input('humedad_suelo.zona3'),
                'humedad_charola4' => $request->input('humedad_suelo.zona4'),
                'ventilador_activo' => $request->input('actuadores.ventilador'),
                'riego_activo' => $request->input('actuadores.riego_activo'),
                
                'fecha_hora' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar en BD: ' . $e->getMessage());
            return response()->json(['message' => 'Error interno al guardar datos'], 500);
        }

        // 3. Lógica para crear alertas 
        if ($request->temperatura > 30) {
             Alerta::create([ /* ... tu lógica de alertas ... */ ]);
        }
        
        return response()->json(['message' => 'Datos recibidos y guardados'], 201);
    }
}