<?php

namespace App\Http\Controllers;

use App\Models\TipoCultivo;
use Illuminate\Http\Request;

class TipoCultivoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255|unique:tipos_cultivos']);
        TipoCultivo::create($request->only('nombre'));
        return back()->with('success', 'Tipo de cultivo creado exitosamente.');
    }

    public function destroy(TipoCultivo $tipoCultivo)
    {
        $tipoCultivo->delete();
        return back()->with('success', 'Tipo de cultivo eliminado exitosamente.');
    }
}