@extends('layouts.cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h3 class="text-center">Login de Cliente</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('cliente.login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label>Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <button class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</div>
@endsection
