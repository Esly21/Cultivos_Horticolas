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
        // 1. Consulta base
    $query = Siembra::with('cultivo', 'estadoSiembra');

    // 👉 Si NO es administrador (id_tipo_usuario = 1), filtrar por usuario
    /*if (Auth::user()->id_tipo_usuario != 1) {
        $query->where('user_id', Auth::id());
    }*/
        $query->where('user_id', Auth::id());
    // 2. Filtro búsqueda
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('notas', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    // 3. Filtro estado
    if ($estado = $request->input('estado')) {
        if ($estado !== 'all') {
            $query->where('estado_siembra_id', $estado);
        }
    }

    // 4. Resultados paginados
    $siembras = $query->latest('fecha_inicio')->paginate(9);

    // 5. Datos para combos
    $cultivos       = Cultivo::where('user_id', Auth()->id())->orderBy('nombre_comun')->get();
    $estados        = EstadoSiembra::all();
    $tiposSuelo     = TipoSuelo::all();
    $calidades      = CalidadCosecha::all();

    return view('siembras.index', compact('siembras', 'cultivos', 'estados', 'tiposSuelo', 'calidades'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cultivo_id' => [
                'required', Rule::exists('cultivos', 'id')->where(function ($query) {
            $query->where('user_id', Auth::id()); }),],
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
            'cultivo_id' => [
                'required',
                Rule::exists('cultivos', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'estado_siembra_id' => 'required|exists:estados_siembra,id',
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