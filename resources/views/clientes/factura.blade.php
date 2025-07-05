<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $pedido->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { margin-bottom: 20px; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #aaa; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Farmacia Online</h2>
<p>Factura #{{ $pedido->id }}</p>
<p>Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
<p>Cliente: {{ $pedido->cliente->nombre }}</p>
<p>Email: {{ $pedido->cliente->email }}</p>

<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedido->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                <td>Q{{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"><strong>Total:</strong></td>
            <td><strong>Q{{ number_format($pedido->total, 2) }}</strong></td>
        </tr>
    </tbody>
</table>

<div class="footer">
    Gracias por tu compra en Farmacia Online.
</div>

</body>
</html>
