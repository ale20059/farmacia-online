@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Nuevo Empleado</h2>

    <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Correo electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Foto (opcional):</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
