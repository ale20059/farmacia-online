<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoAdminController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente')->orderByDesc('created_at')->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'detalles.producto'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function factura($id)
    {
        $pedido = Pedido::with(['cliente', 'detalles.producto'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.pedidos.factura', compact('pedido'));
        return $pdf->download("factura_admin_{$pedido->id}.pdf");
    }
}
