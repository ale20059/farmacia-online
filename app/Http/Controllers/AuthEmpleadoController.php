<?php

// app/Http/Controllers/AuthEmpleadoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class AuthEmpleadoController extends Controller
{
    public function showLoginForm()
    {
        return view('empleados.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('empleado')->attempt($request->only('usuario', 'password'))) {
            return redirect()->route('empleado.dashboard');
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

    public function logout()
    {
        Auth::guard('empleado')->logout();
        return redirect()->route('empleado.login');
    }
}
