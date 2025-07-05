@extends('layouts.admin')

@section('content')
<h2>Detalle del Pedido #{{ $pedido->id }}</h2>

<p><strong>Cliente:</strong> {{ $pedido->cliente->nombre }} ({{ $pedido->cliente->email }})</p>
<p><strong>Total:</strong> Q{{ number_format($pedido->total, 2) }}</p>
<p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedido->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                <td>Q{{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.pedidos.factura', $pedido->id) }}" class="btn btn-primary mt-3">Descargar PDF</a>
@endsection
