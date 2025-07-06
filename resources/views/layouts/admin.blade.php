<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Farmacia Online</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar ampliado -->
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4 class="text-center mb-4">Panel Admin</h4>
            <ul class="nav flex-column">
                <!-- Menú principal -->
                <li class="nav-item">
                    <a href="{{ route('empleado.dashboard') }}" class="nav-link text-white">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>

                <!-- Sección Productos -->
                <li class="nav-item">
                    <a href="{{ route('productos.index') }}" class="nav-link text-white">
                        <i class="fas fa-pills me-2"></i> Productos
                    </a>
                </li>

                <!-- Sección Pedidos -->
                <li class="nav-item">
                    <a href="{{ route('admin.pedidos.index') }}" class="nav-link text-white">
                        <i class="fas fa-clipboard-list me-2"></i> Pedidos
                    </a>
                </li>

                <!-- Sección Proveedores (Nuevo) -->
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link text-white">
                        <i class="fas fa-truck me-2"></i> Proveedores
                    </a>
                </li>

                <!-- Submenú para Proveedores -->
                <li class="nav-item ps-4">
                    <a href="{{ route('proveedores.create') }}" class="nav-link text-white">
                        <i class="fas fa-plus-circle me-2"></i> Nuevo Proveedor
                    </a>
                </li>

                <!-- Sección Facturas (Nuevo) -->
                <li class="nav-item">
                    <a href="{{ route('facturas.index') }}" class="nav-link text-white">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Facturas
                    </a>
                </li>

                <!-- Sección Empleados -->
                <li class="nav-item">
                    <a href="{{ route('empleados.index') }}" class="nav-link text-white">
                        <i class="fas fa-users me-2"></i> Empleados
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('empleado.logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-white bg-transparent border-0">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
