<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bitacora;
use Carbon\Carbon;
class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
    {
        $userId = auth()->id();

        // Filtrar por siembras del usuario
        $query = Bitacora::with('siembra.cultivo')
            ->whereHas('siembra', fn($q) => $q->where('user_id', $userId));

        // Filtro búsqueda
        if ($search = $request->input('search')) {
            $query->where('observaciones', 'like', "%{$search}%");
        }

        // Estadísticas
        $allBitacoras = $query->get();

        $stats = [
            'total'       => $allBitacoras->count(),
            'thisWeek'    => $allBitacoras->where('fecha_seguimiento', '>=', Carbon::now()->subDays(7))->count(),
            'avgTemp'     => $allBitacoras->avg('temperatura_actual'),
            'avgHumidity' => $allBitacoras->avg('humedad_actual'),
        ];

        // Paginación
        $bitacoras = $query->latest('fecha_seguimiento')->paginate(6);

        return view('reportes.index', compact('bitacoras', 'stats'));
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
