<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CarritoController extends Controller
{
    public function factura($id)
    {
        $pedido = Pedido::with(['cliente', 'detalles.producto'])->findOrFail($id);

        $pdf = Pdf::loadView('clientes.factura', compact('pedido'));

        return $pdf->download('factura_' . $pedido->id . '.pdf');
    }

    public function verCarrito()
    {
        $clienteId = Auth::guard('cliente')->id();
        $items = CarritoItem::where('cliente_id', $clienteId)->with('producto')->get();

        $total = $items->sum(fn($item) => $item->producto->precio * $item->cantidad);

        return view('clientes.carrito', compact('items', 'total'));
    }

    public function eliminar(CarritoItem $item)
    {
        $item->delete();
        return back()->with('success', 'Producto eliminado del carrito');
    }

    public function checkout()
    {
        $clienteId = Auth::guard('cliente')->id();
        $items = CarritoItem::where('cliente_id', $clienteId)->with('producto')->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'El carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $total = $items->sum(fn($item) => $item->producto->precio * $item->cantidad);

            $pedido = Pedido::create([
                'cliente_id' => $clienteId,
                'total' => $total,
            ]);

            foreach ($items as $item) {
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto->id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                    'subtotal' => $item->producto->precio * $item->cantidad,
                ]);
            }

            CarritoItem::where('cliente_id', $clienteId)->delete();
            DB::commit();

            return redirect()->route('cliente.factura', $pedido->id);
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Hubo un error al procesar el pedido.');
        }
    }
}
