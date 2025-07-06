@php
    $productosDisponibles = App\Models\Producto::whereDoesntHave('facturaDetalles', function($query) use ($factura) {
        $query->where('factura_id', $factura->id);
    })->get();
@endphp

<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Añadir Productos</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('facturas.detalles.store', $factura) }}" method="POST" id="form-detalle">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select select2" required>
                        <option value="">Seleccione...</option>
                        @foreach($productosDisponibles as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_compra }}">
                                {{ $producto->nombre }} ({{ $producto->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">P. Unitario</label>
                    <input type="number" step="0.01" name="precio_unitario" class="form-control precio-unitario" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Descuento</label>
                    <input type="number" step="0.01" name="descuento" class="form-control" value="0" min="0">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Actualizar precio unitario al seleccionar producto
        $('select[name="producto_id"]').change(function() {
            let precio = $(this).find(':selected').data('precio');
            $('.precio-unitario').val(precio.toFixed(2));
        });

        // Inicializar Select2
        $('.select2').select2({
            placeholder: "Buscar producto...",
            width: '100%'
        });
    });
</script>
@endpush
