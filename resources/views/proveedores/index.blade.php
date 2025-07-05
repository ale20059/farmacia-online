@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Lista de Proveedores</h2>

    <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">Agregar Proveedor</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->correo }}</td>
                    <td>{{ $proveedor->direccion }}</td>
                    <td>
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar este proveedor?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
