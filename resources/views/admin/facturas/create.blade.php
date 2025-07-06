@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3>Nueva Factura</h3>
        <form action="{{ route('facturas.store') }}" method="POST">
            @csrf

            <label>Proveedor *</label>
            <select name="proveedor_id" required>
                <option value="">Selecciona</option>
                @foreach ($proveedores as $p)
                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                @endforeach
            </select>

            <br><br>

            <label>Número Factura *</label>
            <input type="text" name="numero_factura" required>

            <br><br>

            <label>Fecha Emisión *</label>
            <input type="date" name="fecha_emision" value="{{ date('Y-m-d') }}" required>

            <br><br>

            <label>Impuestos (%) *</label>
            <input type="number" name="impuestos" step="0.01" value="12" required>

            <br><br>

            <h4>Productos</h4>

            <div id="productos-container">
                <div>
                    <select name="productos[0][id]" required>
                        <option value="">Selecciona producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="productos[0][cantidad]" value="1" min="1" required>
                    <input type="number" step="0.01" name="productos[0][precio_unitario]" value="0" required>
                    <input type="number" step="0.01" name="productos[0][descuento]" value="0" min="0">
                </div>
            </div>

            <button type="button" onclick="agregarProducto()">Añadir Producto</button>

            <br><br>

            <button type="submit">Guardar Factura</button>
        </form>
    </div>

    <script>
        let index = 1;

        function agregarProducto() {
            const container = document.getElementById('productos-container');
            const div = document.createElement('div');
            div.innerHTML = `
            <select name="productos[${index}][id]" required>
                <option value="">Selecciona producto</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
            <input type="number" name="productos[${index}][cantidad]" value="1" min="1" required>
            <input type="number" step="0.01" name="productos[${index}][precio_unitario]" value="0" required>
            <input type="number" step="0.01" name="productos[${index}][descuento]" value="0" min="0">
            <button type="button" onclick="this.parentElement.remove()">Eliminar</button>
        `;
            container.appendChild(div);
            index++;
        }
    </script>
@endsection
