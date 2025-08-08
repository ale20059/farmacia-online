@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-clipboard-list me-2"></i> Detalle del Pedido #{{ $pedido->id }}</h2>
                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Información del Cliente</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Nombre:</strong> {{ $pedido->cliente->nombre ?? 'Cliente no registrado' }}</p>
                                <p><strong>Email:</strong> {{ $pedido->cliente->email ?? 'N/A' }}</p>
                                <p><strong>Teléfono:</strong> {{ $pedido->cliente->telefono ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Datos del Pedido</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Estado:</strong>
                                    <span
                                        class="badge bg-{{ $pedido->estado == 'completado' ? 'success' : ($pedido->estado == 'pendiente' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </p>
                                <p><strong>Total:</strong> <span
                                        class="fw-bold">Q{{ number_format($pedido->total, 2) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-boxes me-2"></i> Productos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th width="120px">Cantidad</th>
                                        <th width="150px">P. Unitario</th>
                                        <th width="150px">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->detalles as $detalle)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($detalle->producto->imagen)
                                                        <img src="{{ asset('storage/' . $detalle->producto->imagen) }}"
                                                            class="img-thumbnail me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $detalle->producto->nombre }}</h6>
                                                        <small class="text-muted">Código:
                                                            {{ $detalle->producto->codigo }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">{{ $detalle->cantidad }}</td>
                                            <td class="align-middle">Q{{ number_format($detalle->precio_unitario, 2) }}
                                            </td>
                                            <td class="align-middle fw-bold">Q{{ number_format($detalle->subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-comment me-2"></i> Notas</h5>
                            </div>
                            <div class="card-body">
                                {{ $pedido->notas ?? 'No hay notas adicionales' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i> Resumen</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td class="text-end">Q{{ number_format($pedido->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Impuestos:</th>
                                        <td class="text-end">Q{{ number_format($pedido->impuestos, 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <th class="fw-bold">Total:</th>
                                        <td class="text-end fw-bold">Q{{ number_format($pedido->total, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-3">
                    @if ($pedido->estado == 'pendiente')
                        <form action="{{ route('admin.pedidos.completar', $pedido->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-1"></i> Marcar como Completado
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.pedidos.factura', $pedido->id) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-1"></i> Descargar Factura
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
