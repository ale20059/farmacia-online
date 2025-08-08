@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2><i class="fas fa-pills me-2"></i> Editar Producto</h2>
            </div>

            <div class="card-body">
                <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción:</label>
                        <textarea name="descripcion" class="form-control" rows="2">{{ $producto->descripcion }}</textarea>
                    </div>

                    <!-- Precio y Stock -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Precio:</label>
                            <div class="input-group">
                                <span class="input-group-text">Q</span>
                                <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stock:</label>
                            <input type="number" name="stock" value="{{ $producto->stock }}" class="form-control"
                                required>
                        </div>
                    </div>

                    <!-- Proveedor -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Proveedor:</label>
                        <select name="proveedor_id" class="form-select" required>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" @selected($producto->proveedor_id == $proveedor->id)>
                                    {{ $proveedor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Imagen -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Imagen actual:</label>
                        <div class="mb-2">
                            @if ($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" width="120" class="img-thumbnail">
                            @else
                                <span class="badge bg-secondary">Sin imagen</span>
                            @endif
                        </div>
                        <input type="file" name="imagen" class="form-control">
                        <small class="text-muted">Dejar vacío para mantener la imagen actual</small>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
