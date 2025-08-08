@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (ya incluido en layouts.admin) -->
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-users mr-2"></i> Empleados Registrados
                        </h3>
                        <a href="{{ route('empleados.create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Nuevo Empleado
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="100">Foto</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th class="text-center" width="180">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empleados as $empleado)
                                        <tr>
                                            <td>
                                                @if ($empleado->foto)
                                                    <img src="{{ asset('storage/' . $empleado->foto) }}" width="60"
                                                        height="60" class="rounded-circle border"
                                                        alt="Foto de {{ $empleado->nombre }}">
                                                @else
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="fas fa-user-circle text-muted"
                                                            style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ $empleado->nombre }}</td>
                                            <td class="align-middle">{{ $empleado->usuario }}</td>
                                            <td class="align-middle">{{ $empleado->email }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('empleados.edit', $empleado) }}"
                                                        class="btn btn-warning btn-sm" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('empleados.destroy', $empleado) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Estás seguro de eliminar este empleado?')"
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

                        @if ($empleados->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $empleados->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
