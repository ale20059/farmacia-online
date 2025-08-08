<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmaSalud | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primario: #4f6fff;
            --color-secundario: #002aff;
            --color-exito: #4cc9f0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-producto {
            transition: all 0.3s;
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .card-producto:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .img-producto {
            height: 180px;
            object-fit: cover;
            background-color: #f1f8ff;
        }
    </style>
    @yield('styles') <!-- Sección para estilos adicionales -->
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('cliente.tienda') }}">
                <img src="{{ asset('images/logo.png') }}" alt="FarmaSalud Logo" style="height: 120px; width: auto;"
                    class="me-2">
                FarmaSalud
            </a>
            <div class="d-flex">
                @auth('cliente')
                    <a href="{{ route('cliente.carrito') }}" class="btn btn-sm btn-outline-light me-2">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <form action="{{ route('cliente.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('cliente.login') }}" class="btn btn-sm btn-outline-light me-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Ingresar
                    </a>
                    <a href="{{ route('cliente.register') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-user-plus me-1"></i>Registro
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            @auth('cliente')
                <div class="col-md-3 d-none d-md-block">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-bars me-2"></i>Menú
                            </h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('cliente.tienda') }}">
                                        <i class="fas fa-store me-2"></i>Tienda
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('cliente.carrito') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>Carrito
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('cliente.pedidos') }}">
                                        <i class="fas fa-file-invoice me-2"></i>Mis Pedidos
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="@auth('cliente') col-md-9 @else col-12 @endauth">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts') <!-- Sección para scripts adicionales -->
</body>

</html>
