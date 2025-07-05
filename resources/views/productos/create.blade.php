@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Agregar Producto</h2>

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Proveedor:</label>
            <select name="proveedor_id" class="form-control" required>
                <option value="">Selecciona un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Imagen:</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
