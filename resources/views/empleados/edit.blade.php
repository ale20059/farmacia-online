@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Empleado</h2>

    <form action="{{ route('empleados.update', $empleado) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $empleado->nombre }}" required>
        </div>

        <div class="mb-3">
            <label>Correo electrónico:</label>
            <input type="email" name="email" class="form-control" value="{{ $empleado->email }}" required>
        </div>

        <div class="mb-3">
            <label>Nueva Contraseña (opcional):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto actual:</label><br>
            @if ($empleado->foto)
                <img src="{{ asset('storage/' . $empleado->foto) }}" width="80" height="80" class="rounded mb-2">
            @else
                <p class="text-muted">Sin foto</p>
            @endif
        </div>

        <div class="mb-3">
            <label>Actualizar Foto:</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
