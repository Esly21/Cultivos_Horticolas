<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;
class PeriodoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        Periodo::create($request->only('nombre'));
        return back()->with('success', 'Periodo agregado.');
    }

    public function destroy($id)
    {
        // Usamos findOrFail si no usas Route Model Binding para este modelo aún
        Periodo::findOrFail($id)->delete();
        return back()->with('success', 'Periodo eliminado.');
    }
}
