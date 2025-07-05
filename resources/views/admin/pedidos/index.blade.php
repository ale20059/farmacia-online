@extends('layouts.admin')

@section('content')
<h2>Pedidos Realizados</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->cliente->nombre }}</td>
                <td>Q{{ number_format($pedido->total, 2) }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('admin.pedidos.factura', $pedido->id) }}" class="btn btn-success btn-sm">Factura</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
