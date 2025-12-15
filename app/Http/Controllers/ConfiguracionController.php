<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoCultivo;
use App\Models\EstadoSiembra;
use App\Models\TipoSuelo;
use App\Models\Periodo;
use App\Models\Rango;
use App\Models\Dimension;
use App\Models\User;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\TipoSiembra;
class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user()->load('tipoUsuario');
        $tiposCultivo = TipoCultivo::all();
        $estadosSiembra = EstadoSiembra::all();
        $tiposSuelo = TipoSuelo::all();
        $periodos = Periodo::all();
        $rangos = Rango::all();
        $dimensiones = Dimension::all();
        $tiposSiembra = TipoSiembra::all();
        return view('configuracion.index', compact('user', 'tiposCultivo', 'estadosSiembra', 'tiposSuelo', 'periodos', 'rangos', 'dimensiones','tiposSiembra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
