<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoSuelo;
class TipoSueloController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255|unique:tipos_suelos']);
        TipoSuelo::create($request->only('nombre'));
        return back()->with('success', 'Tipo de suelo agregado.');
    }

    public function destroy(TipoSuelo $tipoSuelo)
    {
        $tipoSuelo->delete();
        return back()->with('success', 'Tipo de suelo eliminado.');
    }
}
