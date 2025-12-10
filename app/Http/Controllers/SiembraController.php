<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siembra;
use App\Models\Cultivo;
use App\Models\EstadoSiembra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Asegúrate de importar esta clase
use App\Models\TipoSuelo;
use App\Models\CalidadCosecha;
class SiembraController extends Controller
{
    public function index(Request $request)
    {
       // 1. Inicia la consulta con las relaciones necesarias
        $query = Siembra::with('cultivo', 'estadoSiembra');

        // 2. Aplica el filtro de búsqueda si existe
        if ($search = $request->input('search')) {
            $query->where('notas', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
        }

        // 3. Aplica el filtro de estado si existe y no es 'all'
        if ($estado = $request->input('estado')) {
            if ($estado !== 'all') {
                $query->where('estado_siembra_id', $estado);
            }
        }

        // 4. Obtiene los resultados de la consulta CON FILTROS, los ordena y pagina
        $siembras = $query->latest('fecha_inicio')->paginate(9);

        // 5. Obtiene los datos para los menús desplegables del formulario
        $cultivos = Cultivo::orderBy('nombre_comun')->get();
        $estados = EstadoSiembra::all();
        $tiposSuelo = TipoSuelo::all();
        $calidades = CalidadCosecha::all();
        // 6. Envía todas las variables a la vista
        return view('siembras.index', compact('siembras', 'cultivos', 'estados', 'tiposSuelo', 'calidades'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // --- CORRECCIÓN AQUÍ ---
            // La validación debe apuntar a la columna 'id_cultivo' de la tabla 'cultivos'
            'cultivo_id' => 'required|exists:cultivos,id', 
            'estado_siembra_id' => 'required|exists:estados_siembra,id',
            'fecha_inicio' => 'required|date',
            'fecha_cosecha_estimada' => 'nullable|date|after_or_equal:fecha_inicio',
            'inversion' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
        ]);

        $validatedData['user_id'] = Auth::id();

        Siembra::create($validatedData);

        return redirect()->route('siembras.index')->with('success', 'Siembra registrada exitosamente.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Siembra $siembra)
    {
        // Esta ruta ya no se usa para el modal, pero la dejamos por si acaso
        //$cultivos = Cultivo::orderBy('nombre_comun')->get();
        //$estados = EstadoSiembra::all();
        //return view('siembras.edit', compact('siembra', 'cultivos', 'estados'));
    }

    public function update(Request $request, Siembra $siembra)
    {
        $validatedData = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'estados_siembra_id' => 'required|exists:estados_siembra,id',
            'fecha_inicio' => 'required|date',
            'fecha_cosecha_estimada' => 'nullable|date|after_or_equal:fecha_inicio',
            'inversion' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
        ]);

        $siembra->update($validatedData);

        return redirect()->route('siembras.index')->with('success', 'Siembra actualizada exitosamente.');
    }

    /**
     * Elimina una siembra.
     * --- CORRECCIÓN AQUÍ ---
     * Usamos Route Model Binding (Siembra $siembra) para más eficiencia.
     */
    public function destroy(Siembra $siembra)
    {
        $siembra->delete();
        return redirect()->route('siembras.index')->with('success', 'Siembra eliminada exitosamente.');
    }
}