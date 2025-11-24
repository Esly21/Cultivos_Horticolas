<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alerta;
class AlertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Calcular las estadísticas para las tarjetas superiores
        $stats = [
            'pendientes' => Alerta::where('leida', false)->count(),
            'criticas' => Alerta::where('severidad', 'critical')->where('leida', false)->count(),
            'advertencias' => Alerta::where('severidad', 'warning')->where('leida', false)->count(),
            'resueltas' => Alerta::where('leida', true)->count(),
        ];

        // 2. Iniciar la consulta para la lista de alertas
        $query = Alerta::query();

        // 3. Aplicar filtros
        if ($search = $request->input('search')) {
            $query->where('mensaje', 'like', "%{$search}%");
        }
        if ($severidad = $request->input('severidad')) {
            if ($severidad !== 'all') {
                $query->where('severidad', $severidad);
            }
        }

        // 4. Obtener resultados y paginar
        $alertas = $query->latest('fecha')->paginate(10);

        // 5. Enviar todo a la vista
        return view('alertas.index', compact('alertas', 'stats'));
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
