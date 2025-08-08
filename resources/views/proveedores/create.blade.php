@extends('layouts.admin') {{-- Cambiado de 'layouts.app' a 'layouts.admin' --}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (ya incluido en layouts.admin) -->
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-truck mr-2"></i> Nuevo Proveedor
                        </h3>
                        <a href="{{ route('proveedores.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('proveedores.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono:</label>
                                    <input type="text" name="telefono" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Correo:</label>
                                    <input type="email" name="correo" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dirección:</label>
                                <textarea name="direccion" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-success me-md-2">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
