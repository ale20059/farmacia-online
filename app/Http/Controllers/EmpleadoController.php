<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::latest()->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:empleados,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:200',
            'foto' => 'nullable|image|max:2048', // 2MB máximo
        ]);

        // Guardar la foto si existe
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('empleados', 'public');
        }

        Empleado::create($validated);

        return redirect()->route('empleados.index')
               ->with('success', 'Empleado creado correctamente');
    }

    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:empleados,email,'.$empleado->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:200',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Actualizar foto si se proporciona una nueva
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($empleado->foto) {
                Storage::disk('public')->delete($empleado->foto);
            }
            $validated['foto'] = $request->file('foto')->store('empleados', 'public');
        }

        $empleado->update($validated);

        return redirect()->route('empleados.index')
               ->with('success', 'Empleado actualizado correctamente');
    }

    public function destroy(Empleado $empleado)
    {
        // Eliminar foto si existe
        if ($empleado->foto) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')
               ->with('success', 'Empleado eliminado correctamente');
    }
}
