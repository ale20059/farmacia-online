@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Empleados Registrados</h2>

    <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">Agregar Empleado</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td>
                        @if ($empleado->foto)
                            <img src="{{ asset('storage/' . $empleado->foto) }}" width="60" height="60" class="rounded-circle">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->email }}</td>
                    <td>
                        <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar este empleado?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
