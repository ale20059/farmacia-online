<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:empleados',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|max:2048',
        ]);

        $rutaFoto = null;
        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')->store('empleados', 'public');
        }

        Empleado::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'foto' => $rutaFoto,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:empleados,email,' . $empleado->id,
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Actualiza datos básicos
        $empleado->nombre = $request->nombre;
        $empleado->email = $request->email;

        if ($request->filled('password')) {
            $empleado->password = bcrypt($request->password);
        }

        // Si hay nueva foto
        if ($request->hasFile('foto')) {
            // Borra la anterior
            if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
            }

            $empleado->foto = $request->file('foto')->store('empleados', 'public');
        }

        $empleado->save();

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $empleado)
    {
        // Elimina la foto del disco
        if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
