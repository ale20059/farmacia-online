@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Factura #{{ $factura->numero_factura }}</h3>
        </div>
        <div class="card-body">
            <!-- Encabezado Factura -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Proveedor: {{ $factura->proveedor->nombre }}</h5>
                    <p class="mb-1"><strong>RFC:</strong> {{ $factura->proveedor->rfc }}</p>
                    <p class="mb-1"><strong>Dirección:</strong> {{ $factura->proveedor->direccion }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-1"><strong>Fecha:</strong> {{ $factura->fecha_emision->format('d/m/Y') }}</p>
                    <p class="mb-1"><strong>Estado:</strong>
                        <span class="badge bg-{{ $factura->estado === 'pagada' ? 'success' : 'warning' }}">
                            {{ ucfirst($factura->estado) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Formulario para añadir productos -->
            @include('admin.facturas._form_detalles')

            <!-- Lista de productos -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Cantidad</th>
                            <th>P. Unitario</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factura->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->producto->codigo }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>Q{{ number_format($detalle->descuento, 2) }}</td>
                            <td>Q{{ number_format($detalle->subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('facturas.detalles.destroy', [$factura, $detalle]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totales -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notas">Notas:</label>
                        <textarea class="form-control" rows="2">{{ $factura->notas }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Subtotal:</th>
                                <td class="text-end">Q{{ number_format($factura->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Impuestos ({{ $factura->impuestos }}%):</th>
                                <td class="text-end">Q{{ number_format($factura->subtotal * ($factura->impuestos/100), 2) }}</td>
                            </tr>
                            <tr class="table-active">
                                <th>Total:</th>
                                <td class="text-end fw-bold">Q{{ number_format($factura->total, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
                <div>
                    @if($factura->estado === 'pendiente')
                        <form action="{{ route('facturas.pagar', $factura) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success me-2">
                                <i class="fas fa-check-circle"></i> Marcar como Pagada
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('facturas.pdf', $factura) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Generar PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
