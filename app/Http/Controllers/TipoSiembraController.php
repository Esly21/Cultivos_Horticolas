<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoSiembra;

class TipoSiembraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_siembra,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        TipoSiembra::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Tipo de siembra creado correctamente.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_siembra,nombre,' . $id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        $tipoSiembra = TipoSiembra::findOrFail($id);
        $tipoSiembra->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Tipo de siembra actualizado correctamente.');
    }
    public function destroy($id)
    {
        TipoSiembra::where('id', $id)->delete();

        return back()->with('success', 'Tipo de siembra eliminado correctamente.');
    }
}
