<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $clienteId = Auth::guard('cliente')->id();

        // Obtener todos los pedidos del cliente actual
        $pedidos = Pedido::with('detalles.producto')
                         ->where('cliente_id', $clienteId)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('clientes.pedidos', compact('pedidos'));
    }
}
