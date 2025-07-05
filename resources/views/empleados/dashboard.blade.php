<!-- resources/views/empleados/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Empleado</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1976d2;
            color: white;
            padding: 1em 2em;
        }

        .container {
            padding: 2em;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5em;
        }

        .card {
            background: white;
            padding: 1.5em;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        h1, h2 {
            margin-top: 0;
        }

        .number {
            font-size: 2em;
            color: #1976d2;
        }

        .logout-btn {
            background-color: #e53935;
            color: white;
            border: none;
            padding: 0.6em 1.2em;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 2em;
        }

        a {
            text-decoration: none;
            color: #1976d2;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <h2>Panel de Empleado - Bienvenido, {{ Auth::guard('empleado')->user()->nombre }} 👋</h2>
</header>

<div class="container">
    <div class="grid">
        <div class="card">
            <h3>Productos</h3>
            <p class="number">{{ $totalProductos }}</p>
            <a href="{{ route('productos.index') }}">Ver productos</a>
        </div>

        <div class="card">
            <h3>Pedidos</h3>
            <p class="number">{{ $totalPedidos }}</p>
            <a href="{{ route('admin.pedidos.index') }}">Ver pedidos</a>
        </div>

        <div class="card">
            <h3>Ventas Totales</h3>
            <p class="number">Q{{ number_format($totalVentas, 2) }}</p>
        </div>

        <div class="card">
            <h3>Empleados</h3>
            <p class="number">{{ $totalEmpleados }}</p>
            <a href="{{ route('empleados.index') }}">Ver empleados</a>
        </div>
    </div>

    <form action="{{ route('empleado.logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Cerrar Sesión</button>
    </form>
</div>

</body>
</html>
