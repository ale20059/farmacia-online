<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function showLogin()
    {
        return view('clientes.login');
    }

    public function showRegister()
    {
        return view('clientes.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes',
            'password' => 'required|confirmed|min:6',
        ]);

        Cliente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('cliente.login')->with('success', 'Registrado correctamente');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('cliente')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('cliente.tienda');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout()
    {
        Auth::guard('cliente')->logout();
        return redirect()->route('cliente.login');
    }
}
