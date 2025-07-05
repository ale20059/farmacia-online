@extends('layouts.cliente')

@section('content')
<h2 class="mb-4">Tu Carrito</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($items->isEmpty())
    <div class="alert alert-warning">Tu carrito está vacío.</div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>Q{{ number_format($item->producto->precio, 2) }}</td>
                    <td>Q{{ number_format($item->producto->precio * $item->cantidad, 2) }}</td>
                    <td>
                        <form action="{{ route('cliente.carrito.eliminar', $item) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td colspan="2"><strong>Q{{ number_format($total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('cliente.carrito.checkout') }}" method="POST">
        @csrf
        <button class="btn btn-success w-100">Confirmar Pedido</button>
    </form>
@endif
@endsection
