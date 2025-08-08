@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (ya incluido en layouts.admin) -->
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-user-edit mr-2"></i> Editar Empleado
                        </h3>
                        <a href="{{ route('empleados.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('empleados.update', $empleado) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <input type="text" name="nombre"
                                        class="form-control @error('nombre') is-invalid @enderror"
                                        value="{{ old('nombre', $empleado->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Usuario *</label>
                                    <input type="text" name="usuario"
                                        class="form-control @error('usuario') is-invalid @enderror"
                                        value="{{ old('usuario', $empleado->usuario) }}" required>
                                    @error('usuario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $empleado->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Dejar vacío para no cambiar">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Mínimo 8 caracteres</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Foto actual</label>
                                    <div class="d-flex align-items-center">
                                        @if ($empleado->foto)
                                            <img src="{{ asset('storage/' . $empleado->foto) }}" width="80"
                                                height="80" class="rounded mr-3 border" alt="Foto del empleado">
                                        @else
                                            <div class="text-muted bg-light p-3 rounded">
                                                <i class="fas fa-user-circle fa-3x"></i>
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <small class="d-block text-muted">Foto actual</small>
                                            @if ($empleado->foto)
                                                <a href="#" class="text-danger btn-sm"
                                                    onclick="event.preventDefault(); document.getElementById('remove-photo').submit();">
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Actualizar Foto</label>
                                    <input type="file" name="foto"
                                        class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Formatos: jpg, png, jpeg. Máx. 2MB</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-primary me-md-2">
                                    <i class="fas fa-save"></i> Actualizar Empleado
                                </button>
                                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>

                        @if ($empleado->foto)
                            <form id="remove-photo" action="{{ route('empleados.removePhoto', $empleado->id) }}"
                                method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
