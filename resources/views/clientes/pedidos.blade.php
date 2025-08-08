@extends('layouts.cliente')

@section('title', 'Mis Pedidos')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold text-primary">
                <i class="fas fa-file-invoice me-2"></i>Mis Pedidos
            </h2>
            <a href="{{ route('cliente.tienda') }}" class="btn btn-outline-primary">
                <i class="fas fa-store me-1"></i> Seguir Comprando
            </a>
        </div>

        @if ($pedidos->isEmpty())
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No tienes pedidos registrados</h4>
                    <p class="text-muted mb-4">Cuando realices un pedido, aparecerá aquí</p>
                    <a href="{{ route('cliente.tienda') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-basket me-2"></i>Ir a la tienda
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($pedidos as $pedido)
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div
                                class="card-header bg-light d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <div class="mb-2 mb-md-0">
                                    <span class="badge bg-primary me-2">Pedido #{{ $pedido->id }}</span>
                                    <span class="text-muted">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="fw-bold me-3">Total: Q{{ number_format($pedido->total, 2) }}</span>
                                    <a href="{{ route('cliente.factura', $pedido->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-pdf me-1"></i>Factura
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="table-light">
                                                <th>Producto</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Precio Unitario</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->detalles as $detalle)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($detalle->producto->imagen)
                                                                <img src="{{ asset('storage/' . $detalle->producto->imagen) }}"
                                                                    class="rounded me-3" width="60" height="60"
                                                                    style="object-fit: cover;">
                                                            @else
                                                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                                                    style="width: 60px; height: 60px;">
                                                                    <i class="fas fa-pills text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <span>{{ $detalle->producto->nombre }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                                    <td class="text-end">Q{{ number_format($detalle->precio_unitario, 2) }}
                                                    </td>
                                                    <td class="text-end fw-bold">
                                                        Q{{ number_format($detalle->subtotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Estado del pedido y detalles adicionales -->
                                <div class="mt-3 pt-3 border-top d-flex flex-column flex-md-row justify-content-between">
                                    <div class="mb-2 mb-md-0">
                                        <span class="text-muted me-2">Estado:</span>
                                        <span
                                            class="badge bg-{{ $pedido->estado == 'completado' ? 'success' : 'warning' }}">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-muted me-2">Método de pago:</span>
                                        <span class="fw-bold">{{ $pedido->metodo_pago }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .table th {
            border-top: none;
            font-weight: 500;
            color: #6c757d;
        }
    </style>
@endsection
