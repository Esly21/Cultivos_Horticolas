<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoSiembra;
use Illuminate\Validation\Rule;
class TipoSiembraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_siembra,nombre',
        ]);

        TipoSiembra::create([
            'nombre' => $request->nombre,
        ]);

        return back()->with('success', 'Tipo de siembra creado correctamente.');
    }

    public function destroy($id)
    {
        TipoSiembra::where('id_tipo_siembra', $id)->delete();

        return back()->with('success', 'Tipo de siembra eliminado correctamente.');
    }
}
