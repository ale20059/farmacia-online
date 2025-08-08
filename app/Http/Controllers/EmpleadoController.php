<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{

    public function removePhoto(Empleado $empleado)
    {
        Storage::delete($empleado->foto);
        $empleado->update(['foto' => null]);

        return back()->with('success', 'Foto eliminada correctamente');
    }

    public function index()
    {
        $empleados = Empleado::latest()->paginate(10);
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
            'usuario' => 'required|string|max:50|unique:empleados,usuario',
            'email' => 'required|email|unique:empleados,email',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|max:2048', // 2MB máximo
        ]);

        // Encriptar contraseña antes de guardar
        $validated['password'] = bcrypt($validated['password']);

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
            'usuario' => 'required|string|max:50|unique:empleados,usuario,' . $empleado->id,
            'email' => 'required|email|unique:empleados,email,' . $empleado->id,
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Si cambia la contraseña la encripta
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // No actualizar password si no viene
        }

        // Actualizar foto si se proporciona una nueva
        if ($request->hasFile('foto')) {
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
