<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /*----------------------------------
    | LISTA DE PRODUCTOS
    |----------------------------------*/
    public function index()
    {
        // Trae el proveedor con eager‑loading
        $productos = Producto::with('proveedor')->orderByDesc('id')->get();
        return view('productos.index', compact('productos'));
    }

    /*----------------------------------
    | FORMULARIO NUEVO PRODUCTO
    |----------------------------------*/
    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('productos.create', compact('proveedores'));
    }

    /*----------------------------------
    | GUARDAR PRODUCTO
    |----------------------------------*/
    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'precio'        => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'proveedor_id'  => 'required|exists:proveedores,id',
            'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Sube la imagen (si viene)
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
        }

        Producto::create([
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'precio'        => $request->precio,
            'stock'         => $request->stock,
            'proveedor_id'  => $request->proveedor_id,
            'imagen'        => $rutaImagen,
        ]);

        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    /*----------------------------------
    | FORMULARIO EDITAR PRODUCTO
    |----------------------------------*/
    public function edit(Producto $producto)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'proveedores'));
    }

    /*----------------------------------
    | ACTUALIZAR PRODUCTO
    |----------------------------------*/
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'precio'        => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'proveedor_id'  => 'required|exists:proveedores,id',
            'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Si subieron una nueva imagen, eliminamos la vieja
        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $producto->update([
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'precio'        => $request->precio,
            'stock'         => $request->stock,
            'proveedor_id'  => $request->proveedor_id,
            // 'imagen' ya quedó arriba si cambió
        ]);

        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    /*----------------------------------
    | ELIMINAR PRODUCTO
    |----------------------------------*/
    public function destroy(Producto $producto)
    {
        // Borra la imagen del disco
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
}
