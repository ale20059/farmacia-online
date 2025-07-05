@extends('layouts.cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h3 class="text-center">Registro de Cliente</h3>

        <form action="{{ route('cliente.register.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nombre completo:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control">
            </div>

            <div class="mb-3">
                <label>Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">Registrarse</button>
        </form>
    </div>
</div>
@endsection
