@extends('layouts.cliente')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="fw-bold mb-4 text-primary">
            <i class="fas fa-pills me-2"></i>Catálogo de Medicamentos
        </h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            @foreach($productos as $producto)
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="card card-producto h-100">
                    @if($producto->imagen)
                    <img src="{{ asset('storage/'.$producto->imagen) }}" class="img-producto w-100">
                    @else
                    <div class="img-producto d-flex align-items-center justify-content-center">
                        <i class="fas fa-pills fa-3x text-muted"></i>
                    </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($producto->descripcion, 60) }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-bold text-success">
                                Q{{ number_format($producto->precio, 2) }}
                            </span>
                            <form action="{{ route('cliente.carrito.agregar', $producto) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
