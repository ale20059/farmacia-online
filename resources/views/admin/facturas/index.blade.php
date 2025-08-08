@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Listado de Facturas</h3>
                <a href="{{ route('facturas.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Nueva Factura
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nit</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas as $factura)
                        <tr>
                            <td>{{ $factura->numero_factura }}</td>
                            <td>
                                @if($factura->proveedor)
                                    {{ $factura->proveedor->nombre }}
                                @else
                                    <em>No asignado</em>
                                @endif
                            </td>
                            <td>{{ $factura->fecha_emision->format('d/m/Y') }}</td>
                            <td>Q{{ number_format($factura->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $factura->estado === 'pagada' ? 'success' : 'warning' }}">
                                    {{ ucfirst($factura->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('facturas.pdf', $factura) }}" class="btn btn-sm btn-danger">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay facturas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($facturas->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $facturas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
