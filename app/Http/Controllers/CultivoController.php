<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cultivo;
use App\Models\TipoCultivo;
use Illuminate\Validation\Rule; // Importante para la validación en update
use Illuminate\Support\Facades\Storage;
class CultivoController extends Controller
{
    /**
     * Muestra la lista de cultivos y los datos para el modal.
     */
    public function index(Request $request)
    {
        $query = Cultivo::query();

        if ($search = $request->input('search')) {
            $query->where('nombre_comun', 'like', "%{$search}%")
                  ->orWhere('nombre_cientifico', 'like', "%{$search}%");
        }
        
        $cultivos = $query->latest('id')->paginate(8);
        $tiposCultivo = TipoCultivo::orderBy('nombre')->get();

        return view('cultivos.index', compact('cultivos', 'tiposCultivo'));
    }

    public function store(Request $request)
    {
        //dd($request->all(), $request->file('imagen'));
        $validatedData = $request->validate([
            'nombre_cientifico' => 'required|string|max:150|unique:cultivos',
            'nombre_comun' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'id_tipo_cultivo' => 'required|exists:tipos_cultivo,id',
            'tiempo_riego' => 'nullable|integer|min:0',
            'tiempo_cosecha' => 'nullable|integer|min:0',
            'profundidad_semilla' => 'nullable|numeric|min:0',
            'iluminacion' => 'nullable|boolean',
            'costo' => 'nullable|numeric|min:0',
            'sector' => 'nullable|string|max:100',
            'parcela' => 'nullable|string|max:100',
            'cantidad_de_plantas' => 'nullable|integer|min:0',
        ]);
        
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('cultivos', 'public');
            $validatedData['imagen'] = $path;
        }

        $validatedData['iluminacion'] = $request->has('iluminacion');

        Cultivo::create($validatedData);

        return redirect()->route('cultivos.index')->with('success', 'Cultivo creado exitosamente.');
    }
    /**
     * Muestra el formulario para editar un cultivo.
     */
    public function edit(Cultivo $cultivo )
    {
        $tiposCultivo = TipoCultivo::orderBy('nombre')->get();
        return view('cultivos.edit', compact('cultivo', 'tiposCultivo'));
    }

    /**
     * Actualiza un cultivo existente en la base de datos.
     */
    public function update(Request $request, Cultivo $cultivo)
    {
           $validatedData = $request->validate([
        'nombre_cientifico' => [
            'required',
            'string',
            'max:150',
            Rule::unique('cultivos', 'nombre_cientifico')->ignore($cultivo->id), // Asume primaria 'id'; cambia a $cultivo->id_cultivo si es 'id_cultivo'
        ],
        'nombre_comun' => 'required|string|max:150',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:2048', // Cambia a 'image' para validar archivo, no string
        'id_tipo_cultivo' => 'required|exists:tipos_cultivo,id',
        'tiempo_riego' => 'nullable|integer|min:0',
        'tiempo_cosecha' => 'nullable|integer|min:0',
        'profundidad_semilla' => 'nullable|numeric|min:0',
        'iluminacion' => 'nullable|boolean',
        'costo' => 'nullable|numeric|min:0',
        'sector' => 'nullable|string|max:100',
        'parcela' => 'nullable|string|max:100',
        'cantidad_de_plantas' => 'nullable|integer|min:0',
    ]);
    $validatedData['iluminacion'] = $request->has('iluminacion');
    // Manejo de imagen: Si se sube nueva, guárdala; si no, mantén la actual
    if ($request->hasFile('imagen')) {
        // Opcional: Elimina la imagen anterior si existe
        if ($cultivo->imagen) {
            Storage::disk('public')->delete($cultivo->imagen);
        }
        $path = $request->file('imagen')->store('cultivos', 'public');
        $validatedData['imagen'] = $path;
    } else {
        // Mantén la imagen actual
        unset($validatedData['imagen']);
    }
    $cultivo->update($validatedData);
    return redirect()->route('cultivos.index')->with('success', 'Cultivo actualizado exitosamente.');
    }

    /**
     * Elimina un cultivo de la base de datos.
     */
    public function destroy(Cultivo $cultivo)
    {
        $cultivo->delete();
        return redirect()->route('cultivos.index')->with('success', 'Cultivo eliminado exitosamente.');
    }
}