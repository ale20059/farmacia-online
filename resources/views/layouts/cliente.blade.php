<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Farmacia - Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('cliente.tienda') }}">Farmacia Online</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth('cliente')
                    <li class="nav-item">
                        <span class="nav-link text-white">{{ auth('cliente')->user()->nombre }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('cliente.logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-link nav-link text-white">Cerrar sesión</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('cliente.login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cliente.register') }}">Registro</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    @yield('content')
</main>

</body>
</html>
