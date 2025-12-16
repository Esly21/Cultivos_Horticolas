<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cultivo;
use App\Models\TipoCultivo;
use Illuminate\Validation\Rule;
use App\Models\TipoSiembra;
use App\Models\Periodo;
use App\Models\Rango;
use App\Models\Dimension;
use Illuminate\Support\Facades\Storage;

class CultivoController extends Controller
{
    public function index(Request $request)
    {
        $query = Cultivo::with([
                'tipoSiembra',
                'periodo',
                'rango',
                'dimension',
                'tipoCultivo'
            ])
            ->where('user_id', auth()->id());

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre_comun', 'like', "%{$search}%")
                  ->orWhere('nombre_cientifico', 'like', "%{$search}%");
            });
        }

        return view('cultivos.index', [
            'cultivos'       => $query->latest()->paginate(8),
            'tiposCultivo'   => TipoCultivo::orderBy('nombre')->get(),
            'tiposSiembra'   => TipoSiembra::orderBy('nombre')->get(),
            'periodos'       => Periodo::orderBy('nombre')->get(),
            'rangos'         => Rango::orderBy('nombre')->get(),
            'dimensiones'    => Dimension::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_cientifico' => [
                'required',
                'string',
                'max:150',
                Rule::unique('cultivos', 'nombre_cientifico')
                    ->where('user_id', auth()->id()),
            ],
            'nombre_comun' => [
                'required',
                'string',
                'max:150',
                Rule::unique('cultivos', 'nombre_comun')
                    ->where('user_id', auth()->id()),
            ],
            'descripcion'           => 'nullable|string',
            'imagen'                => 'nullable|image|max:2048',
            'id_tipo_cultivo'       => 'required|exists:tipos_cultivo,id',
            'id_tipo_siembra'       => 'nullable|exists:tipos_siembra,id_tipo_siembra',
            'id_periodo'            => 'nullable|exists:periodos,id_periodo',
            'id_rango'              => 'nullable|exists:rangos,id_rango',
            'id_dimension'          => 'nullable|exists:dimensiones,id_dimension',
            'tiempo_cosecha'        => 'nullable|integer|min:0',
            'tiempo_riego'          => 'nullable|integer|min:0',
            'profundidad_semilla'   => 'nullable|numeric|min:0',
            'costo'                 => 'nullable|numeric|min:0',
            'sector'                => 'nullable|string|max:100',
            'parcela'               => 'nullable|string|max:100',
            'cantidad_de_plantas'   => 'nullable|integer|min:0',
            'iluminacion'           => 'nullable|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('cultivos', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['iluminacion'] = $request->has('iluminacion');

        Cultivo::create($validated);

        return redirect()
            ->route('cultivos.index')
            ->with('success', 'Cultivo creado exitosamente.');
    }

    public function edit(Cultivo $cultivo)
    {
        $this->authorizeOwnership($cultivo);

        return view('cultivos.edit', [
            'cultivo'        => $cultivo,
            'tiposCultivo'   => TipoCultivo::orderBy('nombre')->get(),
            'tiposSiembra'   => TipoSiembra::orderBy('nombre')->get(),
            'periodos'       => Periodo::orderBy('nombre')->get(),
            'rangos'         => Rango::orderBy('nombre')->get(),
            'dimensiones'    => Dimension::all(),
        ]);
    }

    public function update(Request $request, Cultivo $cultivo)
    {
        $this->authorizeOwnership($cultivo);

        $validated = $request->validate([
            'nombre_cientifico' => [
                'required',
                'string',
                'max:150',
                Rule::unique('cultivos', 'nombre_cientifico')
                    ->where('user_id', auth()->id())
                    ->ignore($cultivo->id),
            ],
            'nombre_comun' => [
                'required',
                'string',
                'max:150',
                Rule::unique('cultivos', 'nombre_comun')
                    ->where('user_id', auth()->id())
                    ->ignore($cultivo->id),
            ],
            'descripcion'           => 'nullable|string',
            'imagen'                => 'nullable|image|max:2048',
            'id_tipo_cultivo'       => 'required|exists:tipos_cultivo,id',
            'id_tipo_siembra'       => 'nullable|exists:tipos_siembra,id_tipo_siembra',
            'id_periodo'            => 'nullable|exists:periodos,id_periodo',
            'id_rango'              => 'nullable|exists:rangos,id_rango',
            'id_dimension'          => 'nullable|exists:dimensiones,id_dimension',
            'tiempo_cosecha'        => 'nullable|integer|min:0',
            'tiempo_riego'          => 'nullable|integer|min:0',
            'profundidad_semilla'   => 'nullable|numeric|min:0',
            'costo'                 => 'nullable|numeric|min:0',
            'sector'                => 'nullable|string|max:100',
            'parcela'               => 'nullable|string|max:100',
            'cantidad_de_plantas'   => 'nullable|integer|min:0',
            'iluminacion'           => 'nullable|boolean',
        ]);

        $validated['iluminacion'] = $request->has('iluminacion');

        if ($request->hasFile('imagen')) {
            if ($cultivo->imagen) {
                Storage::disk('public')->delete($cultivo->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('cultivos', 'public');
        }

        $cultivo->update($validated);

        return redirect()
            ->route('cultivos.index')
            ->with('success', 'Cultivo actualizado exitosamente.');
    }

    public function destroy(Cultivo $cultivo)
    {
        $this->authorizeOwnership($cultivo);

        if ($cultivo->imagen) {
            Storage::disk('public')->delete($cultivo->imagen);
        }

        $cultivo->delete();

        return redirect()
            ->route('cultivos.index')
            ->with('success', 'Cultivo eliminado exitosamente.');
    }

    private function authorizeOwnership(Cultivo $cultivo)
    {
        if ($cultivo->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
