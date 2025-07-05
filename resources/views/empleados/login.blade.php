<!-- resources/views/empleados/login.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Empleado</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            background: white;
            padding: 2em;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 300px;
        }
        input {
            display: block;
            width: 100%;
            margin-bottom: 1em;
            padding: 0.8em;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 0.8em;
            border: none;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
<div class="login-card">
    <h2>Login Empleado</h2>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('empleado.login.post') }}" method="POST">
        @csrf
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
</body>
</html>
