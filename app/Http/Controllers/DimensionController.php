<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dimension;
class DimensionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'largo' => 'required|numeric',
            'ancho' => 'required|numeric',
            'altura' => 'required|numeric',
        ]);
        
        Dimension::create($request->all());
        return back()->with('success', 'Dimensión agregada.');
    }

    public function destroy($id)
    {
        Dimension::findOrFail($id)->delete();
        return back()->with('success', 'Dimensión eliminada.');
    }
}
