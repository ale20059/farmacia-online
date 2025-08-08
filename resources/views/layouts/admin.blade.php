<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - PHARMA FDINOVA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #2370ff 0%, #156bff 100%);
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #fff;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        .logo-brand {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-brand img {
            height: 140px;
            margin-bottom: 10px;
        }

        .user-profile {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 10px;
        }

        .user-name {
            color: white;
            font-weight: 500;
            margin-bottom: 0;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar text-white p-0" style="width: 250px;">
            <div class="logo-brand">
                <img src="{{ asset('images/logo.png') }}" alt="PHARMA FDINOVA">
                <h5 class="text-white mb-0">PANEL ADMIN</h5>
            </div>

            <!-- Perfil del Empleado -->
            <div class="user-profile">
                @if (Auth::guard('empleado')->user()->foto)
                    <img src="{{ asset('storage/' . Auth::guard('empleado')->user()->foto) }}" class="user-avatar"
                        alt="Foto de perfil">
                @else
                    <div class="user-avatar bg-light d-flex align-items-center justify-content-center mx-auto">
                        <i class="fas fa-user text-dark" style="font-size: 2rem;"></i>
                    </div>
                @endif
                <h6 class="user-name">{{ Auth::guard('empleado')->user()->nombre }}</h6>
                <span class="user-role">Empleado</span>
            </div>

            <div class="p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('empleado.dashboard') }}"
                            class="nav-link {{ Route::is('empleado.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('productos.index') }}"
                            class="nav-link {{ Route::is('productos.*') ? 'active' : '' }}">
                            <i class="fas fa-pills me-2"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pedidos.index') }}"
                            class="nav-link {{ Route::is('admin.pedidos.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list me-2"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('proveedores.index') }}"
                            class="nav-link {{ Route::is('proveedores.*') ? 'active' : '' }}">
                            <i class="fas fa-truck me-2"></i> Proveedores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('facturas.index') }}"
                            class="nav-link {{ Route::is('facturas.*') ? 'active' : '' }}">
                            <i class="fas fa-file-invoice-dollar me-2"></i> Facturas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleados.index') }}"
                            class="nav-link {{ Route::is('empleados.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Empleados
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <form method="POST" action="{{ route('empleado.logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-white bg-transparent border-0 w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4 bg-light">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
