@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Producto</h2>

    <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" value="{{ $producto->stock }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Proveedor:</label>
            <select name="proveedor_id" class="form-control" required>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" @selected($producto->proveedor_id == $proveedor->id)>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Imagen actual:</label><br>
            @if ($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" width="100" height="100" class="rounded mb-2">
            @else
                <p class="text-muted">No hay imagen</p>
            @endif
            <input type="file" name="imagen" class="form-control">
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
