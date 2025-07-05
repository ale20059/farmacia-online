@extends('layouts.cliente')

@section('content')
<h2 class="mb-4">Catálogo de Productos</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    @foreach ($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if ($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                @else
                    <div class="p-4 text-center text-muted">Sin imagen</div>
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                    <p class="card-text">{{ Str::limit($producto->descripcion, 70) }}</p>
                    <p><strong>Precio: </strong>Q{{ number_format($producto->precio, 2) }}</p>

                    <form action="{{ route('cliente.carrito.agregar', $producto) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
