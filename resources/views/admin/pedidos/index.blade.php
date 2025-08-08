@extends('layouts.admin')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h3 class="mb-0">Pedidos Realizados</h3>
            <a href="#" class="btn btn-light btn-sm">Exportar</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>{{ $pedido->cliente->nombre }}</td>
                                <td class="font-weight-bold">Q{{ number_format($pedido->total, 2) }}</td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-success">Completado</span>
                                    <!-- Cambia el badge según tu lógica:
                                         badge-success (completado),
                                         badge-warning (pendiente), etc. -->
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-info btn-sm"
                                            title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pedidos.factura', $pedido->id) }}"
                                            class="btn btn-success btn-sm" title="Descargar factura">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->

        </div>
    </div>
@endsection
