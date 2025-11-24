<?php

namespace App\Http\Controllers;

use App\Models\EstadoSiembra;
use Illuminate\Http\Request;

class EstadoSiembraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['estado' => 'required|string|max:255|unique:estados_siembra']);
        EstadoSiembra::create($request->only('estado'));
        return back()->with('success', 'Estado de siembra creado exitosamente.');
    }

    public function destroy(EstadoSiembra $estadoSiembra)
    {
        $estadoSiembra->delete();
        return back()->with('success', 'Estado de siembra eliminado exitosamente.');
    }
}