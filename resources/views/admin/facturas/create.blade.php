@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2><i class="fas fa-file-invoice-dollar"></i> Nueva Factura</h2>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('facturas.store') }}" method="POST" id="facturaForm">
                @csrf

                <!-- Información Básica -->
                <div class="row mb-4">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número de Factura *</label>
                        <input type="text" name="numero_factura" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo de Moneda *</label>
                        <select name="moneda" class="form-select" required>
                            <option value="GTQ">Quetzales (GTQ)</option>
                            <option value="USD">Dólares (USD)</option>
                            <option value="EUR">Euros (EUR)</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Emisión *</label>
                        <input type="date" name="fecha_emision" value="{{ now()->format('Y-m-d') }}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Impuestos (%) *</label>
                        <input type="number" step="0.01" name="impuestos" value="12" class="form-control" required>
                    </div>
                </div>

                <!-- Productos -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        Productos
                    </div>
                    <div class="card-body" id="productos-container">
                        <!-- Aquí se agregan los productos dinámicamente -->
                    </div>
                    <div class="card-footer">
                        <button type="button" id="agregarProductoBtn" class="btn btn-success">
                            <i class="fas fa-plus"></i> Agregar Producto
                        </button>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Notas</label>
                        <textarea name="notas" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Subtotal</th>
                                <td id="subtotal">Q0.00</td>
                            </tr>
                            <tr>
                                <th>Impuestos</th>
                                <td id="impuestos">Q0.00</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td id="total" class="fw-bold">Q0.00</td>
                            </tr>
                        </table>
                    </div>
                </div>


                <!-- Botones -->
                <div class="text-end">
                    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Factura</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const productos = @json($productos);

    document.addEventListener('DOMContentLoaded', function () {
        let index = 0;
        const container = document.getElementById('productos-container');
        const agregarBtn = document.getElementById('agregarProductoBtn');

        agregarBtn.addEventListener('click', () => agregarProducto());

        function agregarProducto() {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'align-items-center');
            row.innerHTML = `
                <div class="col-md-4">
                    <select name="productos[${index}][id]" class="form-select producto-select" required>
                        <option value="">Seleccione producto</option>
                        ${productos.map(p => `<option value="${p.id}" data-precio="${p.precio}">${p.nombre}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" placeholder="cantidad" name="productos[${index}][cantidad]" value="" min="1" class="form-control cantidad" required>
                </div>
                <div class="col-md-2">
                    <input type="number" placeholder="precio" step="0.01" name="productos[${index}][precio_unitario]" class="form-control precio" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" placeholder="descuento" name="productos[${index}][descuento]" value="" min="0" class="form-control descuento">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm eliminar-producto">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            container.appendChild(row);
            index++;

            row.querySelector('.producto-select').addEventListener('change', e => {
                const precio = e.target.selectedOptions[0].dataset.precio;
                row.querySelector('.precio').value = precio;
                calcularTotales();
            });

            row.querySelectorAll('.cantidad, .precio, .descuento').forEach(input => {
                input.addEventListener('input', calcularTotales);
            });

            row.querySelector('.eliminar-producto').addEventListener('click', () => {
                row.remove();
                calcularTotales();
            });

            calcularTotales();
        }

        document.querySelector('input[name="impuestos"]').addEventListener('input', calcularTotales);

        function calcularTotales() {
            let subtotal = 0;
            document.querySelectorAll('#productos-container .row').forEach(row => {
                const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
                const precio = parseFloat(row.querySelector('.precio').value) || 0;
                const descuento = parseFloat(row.querySelector('.descuento').value) || 0;
                subtotal += (cantidad * precio) - descuento;
            });

            const impuestosPorcentaje = parseFloat(document.querySelector('input[name="impuestos"]').value) || 0;
            const impuestos = subtotal * (impuestosPorcentaje / 100);
            const total = subtotal + impuestos;

            document.getElementById('subtotal').textContent = 'Q' + subtotal.toFixed(2);
            document.getElementById('impuestos').textContent = 'Q' + impuestos.toFixed(2);
            document.getElementById('total').textContent = 'Q' + total.toFixed(2);
        }

        // Carga un producto inicial
        agregarProducto();
    });
</script>
@endsection
