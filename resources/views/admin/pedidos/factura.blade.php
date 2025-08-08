<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura Pedido #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 75mm;
            margin: 0 auto;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .totales td {
            text-align: right;
        }

        .totales td:first-child {
            text-align: left;
        }

        @page {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="center bold">
        PHARMA FDINOVA<br>
        NIT: 123456789<br>
        Tel: 555-1234-567<br>
        FACTURA PEDIDO
    </div>

    <div class="line"></div>

    <p><strong>Pedido:</strong> #{{ $pedido->id }}</p>
    <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre }}</p>
    <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y') }}</p>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <td><strong>Producto</strong></td>
                <td style="text-align:right;"><strong>Subtotal</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido->detalles as $detalle)
                <tr>
                    <td colspan="2">{{ $detalle->producto->nombre }}</td>
                </tr>
                <tr>
                    <td>{{ $detalle->cantidad }} x Q{{ number_format($detalle->producto->precio, 2) }}</td>
                    <td style="text-align:right;">
                        Q{{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <table class="totales">
        <tr class="bold">
            <td>TOTAL:</td>
            <td>
                Q{{ number_format($pedido->detalles->sum(fn($d) => $d->producto->precio * $d->cantidad), 2) }}
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="center">
        Factura generada el:<br>{{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="center" style="margin-top: 10px;">
        ¡Gracias por su compra!
    </div>
</body>

</html>
