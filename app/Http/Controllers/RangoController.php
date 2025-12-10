<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rango;
class RangoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        Rango::create($request->only('nombre'));
        return back()->with('success', 'Rango agregado.');
    }

    public function destroy($id)
    {
        Rango::findOrFail($id)->delete();
        return back()->with('success', 'Rango eliminado.');
    }
}
