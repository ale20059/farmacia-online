@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Lista de Productos</h2>

    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Agregar Producto</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td>
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" width="60" height="60" class="rounded">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>
                    <td>{{ $producto->nombre }}</td>
                    <td>Q{{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->proveedor->nombre ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar este producto?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay productos registrados aún.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
