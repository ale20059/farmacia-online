<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::latest()->paginate(10); // Paginación para mejor rendimiento
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100|unique:proveedores,correo',
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El nombre del proveedor es obligatorio',
            'correo.email' => 'Debe ingresar un correo electrónico válido',
            'correo.unique' => 'Este correo ya está registrado para otro proveedor'
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function edit($id) // Cambia a recibir el ID directamente
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id) // Cambia a recibir el ID
    {
        $proveedor = Proveedor::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'nullable|string',
            'correo' => 'nullable|email',
            'direccion' => 'nullable|string',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->delete();

            return redirect()->route('proveedores.index')
                ->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se pudo eliminar el proveedor: ' . $e->getMessage());
        }
    }
}
