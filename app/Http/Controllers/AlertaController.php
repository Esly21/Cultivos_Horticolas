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
        $userId = auth()->id();

        // Estadísticas solo del usuario
        $stats = [
            'pendientes'   => Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
                                    ->where('leida', 0)->count(),
            'criticas'     => Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
                                    ->where('severidad', 'critical')->where('leida', 0)->count(),
            'advertencias' => Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
                                    ->where('severidad', 'warning')->where('leida', 0)->count(),
            'resueltas'    => Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
                                    ->where('leida', 1)->count(),
        ];

        // Consulta principal filtrada
        $query = Alerta::whereHas('siembra', fn($q) => $q->where('user_id', $userId))
                       ->with('siembra')
                       ->orderBy('fecha', 'desc');

        // Filtro búsqueda
        if ($request->filled('search')) {
            $query->where('mensaje', 'like', '%' . $request->search . '%');
        }

        // Filtro severidad
        if ($request->filled('severidad') && $request->severidad !== 'all') {
            $query->where('severidad', $request->severidad);
        }

        // Filtro estado (pendientes / resueltas)
        if ($request->filled('estado_alerta')) {
            if ($request->estado_alerta === 'resueltas') {
                $query->where('leida', 1);
            } else {
                // caso por defecto: pendientes
                $query->where('leida', 0);
            }
        } else {
            // Si no viene el filtro, mostrar pendientes
            $query->where('leida', 0);
        }

        // Paginación
        $alertas = $query->paginate(10);

        return view('alertas.index', compact('alertas', 'stats'));
    }
}