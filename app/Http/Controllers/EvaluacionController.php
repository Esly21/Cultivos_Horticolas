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
  public function index(Request $request)
{
    $userId = auth()->id();

    // 1. Preparamos la consulta base (sin ejecutarla aún)
    $query = EvaluacionRendimiento::where('user_id', $userId)
        ->with(['siembra.cultivo', 'tipoSuelo', 'calidad']);

    // 2. Si hay búsqueda, filtramos la consulta
    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search) {
            $q->whereHas('siembra.cultivo', function($sq) use ($search) {
                $sq->where('nombre_comun', 'like', "%{$search}%");
            })
            ->orWhereHas('tipoSuelo', function($sq) use ($search) {
                $sq->where('nombre', 'like', "%{$search}%");
            });
        });
    }

    // 3. Calculamos los totales usando la consulta YA FILTRADA
    // Usamos 'clone' para no romper la paginación que viene después
    $totalEvaluaciones = (clone $query)->count();
    $promedioRendimiento = (clone $query)->avg('cantidad_cosechada');
    $totalIngresos = (clone $query)->sum('ingresos_estimados');
    
    // Contamos calidad "Buena" respetando el filtro
    $mejorCalidadCount = (clone $query)
        ->whereHas('calidad', fn($q) => $q->where('nombre', 'Buena'))
        ->count();

    // 4. Finalmente obtenemos la lista paginada para la tabla
    $evaluaciones = $query->latest()->paginate(10);

    // Datos para el formulario (Modales)
    $siembras = Siembra::where('user_id', $userId)->get();
    $siembrasPendientes = Siembra::where('user_id', $userId)
        ->whereDoesntHave('evaluaciones')
        ->get();
    $tiposSuelo = TipoSuelo::all();
    $calidades = CalidadCosecha::all();

    return view('evaluaciones.index', compact(
        'evaluaciones',
        'siembras',
        'siembrasPendientes',
        'tiposSuelo',
        'calidades',
        'totalEvaluaciones',
        'promedioRendimiento',
        'mejorCalidadCount',
        'totalIngresos'
    ));
}
    
public function store(Request $request)
    {
        $request->validate([
        // 'user_id' => 'required|exists:users,id',  <-- ESTA LINEA CAUSABA EL ERROR
        'siembra_id'         => 'required|exists:siembras,id',
        'tipo_suelo_id'      => 'required|exists:tipos_suelos,id',
        'fecha_cosecha_real' => 'required|date',
        'cantidad_cosechada' => 'required|numeric|min:0',
        'ingresos_estimados' => 'required|numeric|min:0',
        'calidad_id'         => 'required|exists:calidad_cosechas,id',
        'tamano_promedio'    => 'required|string',
        'tipo_cosecha'       => 'required|string',
        'observaciones'      => 'nullable|string', // Es bueno validar observaciones como opcional
    ]);

    // 2. Lógica para calcular días
    $siembra = Siembra::find($request->siembra_id);
    
    // CORRECCIÓN RECOMENDADA: Calcula los días con la fecha real de cosecha, no con "ahora"
    // Si usas Carbon::now() y registras la evaluación una semana después, el cálculo será incorrecto.
    $fechaCosecha = Carbon::parse($request->fecha_cosecha_real);
    $dias = Carbon::parse($siembra->fecha_siembra)->diffInDays($fechaCosecha);

    // 3. Crear el registro (Aquí asignamos el user_id manualmente)
    EvaluacionRendimiento::create([
        'user_id'            => auth()->id(), // <--- Aquí ya se asigna correctamente
        'siembra_id'         => $request->siembra_id,
        'tipo_suelo_id'      => $request->tipo_suelo_id,
        'fecha_cosecha_real' => $request->fecha_cosecha_real,
        'cantidad_cosechada' => $request->cantidad_cosechada,
        'ingresos_estimados' => $request->ingresos_estimados,
        'calidad_id'         => $request->calidad_id,
        'tamano_promedio'    => $request->tamano_promedio,
        'tipo_cosecha'       => $request->tipo_cosecha,
        'observaciones'      => $request->observaciones,
        'dias_transcurridos' => $dias,
    ]);

    return redirect()->back()->with('success', 'Evaluación registrada correctamente');
    }
    public function destroy($id)
    {
        $evaluacion = EvaluacionRendimiento::where('user_id', auth()->id())->findOrFail($id);
        $evaluacion->delete();
        return redirect()->back()->with('success', 'Evaluación eliminada correctamente.');
    }
    
}
