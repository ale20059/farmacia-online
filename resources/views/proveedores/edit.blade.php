@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Proveedor</h2>

    <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ $proveedor->nombre }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono:</label>
            <input type="text" name="telefono" value="{{ $proveedor->telefono }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Correo:</label>
            <input type="email" name="correo" value="{{ $proveedor->correo }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección:</label>
            <textarea name="direccion" class="form-control">{{ $proveedor->direccion }}</textarea>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
