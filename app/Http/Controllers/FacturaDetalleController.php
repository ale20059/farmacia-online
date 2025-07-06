<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Producto;
use Illuminate\Http\Request;

class FacturaDetalleController extends Controller
{
    // Añadir producto a factura existente
    public function store(Request $request, Factura $factura)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'descuento' => 'nullable|numeric|min:0'
        ]);

        $producto = Producto::find($request->producto_id);

        $detalle = $factura->detalles()->create([
            'producto_id' => $producto->id,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $producto->precio_compra,
            'descuento' => $request->descuento ?? 0
        ]);

        // Actualizar stock
        $producto->increment('stock', $request->cantidad);

        // Recalcular totales
        $factura->calcularTotal();

        return back()->with('success', 'Producto añadido a la factura');
    }

    // Eliminar producto de factura
    public function destroy(Factura $factura, FacturaDetalle $detalle)
    {
        // Validar que el detalle pertenezca a la factura
        if ($detalle->factura_id !== $factura->id) {
            abort(403, 'Acción no autorizada');
        }

        $producto = $detalle->producto;
        $cantidad = $detalle->cantidad;

        $detalle->delete();

        // Revertir stock
        $producto->decrement('stock', $cantidad);

        // Recalcular totales
        $factura->calcularTotal();

        return back()->with('success', 'Producto eliminado de la factura');
    }

}
