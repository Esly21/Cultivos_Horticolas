<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Validación de rol: solo admin puede acceder
        if (auth()->user()->id_tipo_usuario != 1) {
            abort(403, 'Acceso no autorizado.');
        }

       $usuarios = User::withCount('siembras') // 1. Agrega el campo 'siembras_count'
            ->with(['siembras.cultivo'])        // 2. Carga las siembras y sus cultivos para el modal
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('usuarios'));
    }

    public function destroy(User $user)
    {
        // Evitar que el usuario se elimine a sí mismo
        if (auth()->user()->id === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
     

}
