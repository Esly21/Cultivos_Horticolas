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

    // --- CONVERSIÓN DE HUMEDAD (0–1023 → 0–100%) ---
    $maxValor = 1023; // Cambia a 1026 si tu sensor usa ese rango

    $raw1 = $request->input('humedad_suelo.zona1');
    $raw2 = $request->input('humedad_suelo.zona2');
    $raw3 = $request->input('humedad_suelo.zona3');
    $raw4 = $request->input('humedad_suelo.zona4');

    $humedad1 = ($raw1 !== null) ? ($raw1 / $maxValor) * 100 : null;
    $humedad2 = ($raw2 !== null) ? ($raw2 / $maxValor) * 100 : null;
    $humedad3 = ($raw3 !== null) ? ($raw3 / $maxValor) * 100 : null;
    $humedad4 = ($raw4 !== null) ? ($raw4 / $maxValor) * 100 : null;
    // -------------------------------------------------

    // 2. Guardar lectura ambiental
    try {
        VariableAmbiental::create([
            'siembra_id' => $request->device_id,
            'user_id' => $siembraUserId,
            'temperatura' => $request->temperatura,
            'humedad' => $request->humedad_ambiente,
            'luminosidad_lux' => $request->luz,

            // CONVERSIONES A PORCENTAJE
            'humedad_charola1' => $humedad1,
            'humedad_charola2' => $humedad2,
            'humedad_charola3' => $humedad3,
            'humedad_charola4' => $humedad4,

            'ventilador_activo' => $request->input('actuadores.ventilador'),
            'riego_activo' => $request->input('actuadores.riego_activo'),

            'fecha_hora' => now(),
        ]);
    } catch (\Exception $e) {
        Log::error('Error al guardar en BD: ' . $e->getMessage());
        return response()->json(['message' => 'Error interno al guardar datos'], 500);
    }

    // 3. Crear registro en Bitácora
    Bitacora::create([
        'siembra_id' => $request->device_id,
        'user_id' => $siembraUserId,
        'fecha_seguimiento' => now(),
        'temperatura_actual' => $request->temperatura,
        'humedad_actual' => $request->humedad_ambiente,
        'observaciones' => 'Lectura automática desde ESP8266',
    ]);

    // 4. Lógica para alertas
    if ($request->temperatura > 30) {
        Alerta::create([
            'siembra_id' => $request->device_id,
            'user_id' => $siembraUserId,
            'mensaje' => 'Temperatura elevada: ' . $request->temperatura . '°C',
            'severidad' => 'critical',
            'fecha' => now(),
            'leida' => false,
        ]);
    }

    if ($request->humedad_ambiente < 40) {
        Alerta::create([
            'siembra_id' => $request->device_id,
            'user_id' => $siembraUserId,
            'mensaje' => 'Humedad baja: ' . $request->humedad_ambiente . '%',
            'severidad' => 'warning',
            'fecha' => now(),
            'leida' => false,
        ]);
    }
    function crearAlertaHumedadSuelo($valor, $zona, $siembraId) {
        if ($valor === null) return;
        if ($valor < 30) { 
            Alerta::create([
                'siembra_id' => $siembraId,
                 'user_id' => $siembraUserId,
                'mensaje' => "Humedad baja en charola {$zona}: " . number_format($valor, 1) . '%',
                'severidad' => 'warning',
                'fecha' => now(),
                'leida' => false,
            ]);
        }
        if ($valor > 80) {
            Alerta::create([
                'siembra_id' => $siembraId,
                 'user_id' => $siembraUserId,
                'mensaje' => "Humedad alta en charola {$zona}: " . number_format($valor, 1) . '%',
                'severidad' => 'critical',
                'fecha' => now(),
                'leida' => false,
            ]);
        }
    }
crearAlertaHumedadSuelo($humedad1, 1, $request->device_id);
crearAlertaHumedadSuelo($humedad2, 2, $request->device_id);
crearAlertaHumedadSuelo($humedad3, 3, $request->device_id);
crearAlertaHumedadSuelo($humedad4, 4, $request->device_id);

    return response()->json(['message' => 'Datos recibidos y guardados'], 201);
}

}