<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .totals {
            float: right;
            width: 300px;
        }

        .footer {
            margin-top: 50px;
            font-size: 0.8em;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Farmacia Online</h2>
        <p>RFC: FAM123456789 | Tel: 555-1234-567</p>
    </div>

    <div class="info">
        <p><strong>Factura:</strong> {{ $factura->numero_factura }}</p>
        <p><strong>Fecha:</strong> {{ $factura->fecha_emision->format('d/m/Y') }}</p>
        <p><strong>Proveedor:</strong> {{ $factura->proveedor->nombre }}</p>
        <p><strong>RFC Proveedor:</strong> {{ $factura->proveedor->rfc }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>P. Unitario</th>
                <th>Descuento</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($factura->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>Q{{ number_format($detalle->descuento, 2) }}</td>
                    <td>Q{{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <th>Subtotal:</th>
                <td>Q{{ number_format($factura->subtotal, 2) }}</td>
            </tr>
            <tr>
                <th>IVA ({{ $factura->impuestos }}%):</th>
                <td>Q{{ number_format($factura->subtotal * ($factura->impuestos / 100), 2) }}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <td><strong>Q{{ number_format($factura->total, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Factura generada el: {{ now()->format('d/m/Y H:i') }}</p>
        <p>Farmacia Online - Todos los derechos reservados</p>
    </div>
</body>

</html>
