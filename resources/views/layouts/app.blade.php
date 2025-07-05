<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Farmacia')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Estilos personalizados opcionales --}}
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Farmacia Online</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth('empleado')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empleados.index') }}">Empleados</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Cerrar sesión</button>
                            </form>
                        </li>
                    @endauth

                    @guest('empleado')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
