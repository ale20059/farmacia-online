<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CarritoItem;

class TiendaController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('clientes.tienda', compact('productos'));
    }

    public function agregarAlCarrito(Request $request, Producto $producto)
    {
        $clienteId = Auth::guard('cliente')->id();

        // Buscar si ya está en el carrito
        $item = CarritoItem::where('cliente_id', $clienteId)
            ->where('producto_id', $producto->id)
            ->first();

        if ($item) {
            $item->cantidad += 1;
            $item->subtotal = $item->cantidad * $item->precio_unitario;
            $item->save();
        } else {
            CarritoItem::create([
                'cliente_id' => $clienteId,
                'producto_id' => $producto->id,
                'cantidad' => 1,
                'precio_unitario' => $producto->precio,
                'subtotal' => $producto->precio * 1,
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }
}
