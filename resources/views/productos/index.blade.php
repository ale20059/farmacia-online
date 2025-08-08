@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-pills me-2"></i> Lista de Productos</h2>
                    <a href="{{ route('productos.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-1"></i> Agregar Producto
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($productos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th width="100px">Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Proveedor</th>
                                    <th width="150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>
                                            @if ($producto->imagen)
                                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-thumbnail"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $producto->nombre }}</td>
                                        <td class="align-middle">Q{{ number_format($producto->precio, 2) }}</td>
                                        <td class="align-middle">
                                            <span
                                                class="badge bg-{{ $producto->stock > 10 ? 'success' : ($producto->stock > 0 ? 'warning' : 'danger') }}">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
                                        <td class="align-middle">{{ $producto->proveedor->nombre ?? 'N/A' }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('productos.edit', $producto) }}"
                                                    class="btn btn-sm btn-warning flex-grow-1" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                                    class="d-inline flex-grow-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                                        onclick="return confirm('¿Eliminar este producto?')"
                                                        title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                        <h5>No hay productos registrados</h5>
                        <a href="{{ route('productos.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i> Agregar Primer Producto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
