<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\FacturaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    public function pagar(Factura $factura)
    {
        // Verifica si ya está pagada
        if ($factura->estado === 'pagada') {
            return back()->with('warning', '¡La factura ya estaba pagada!');
        }

        // Actualiza el estado
        $factura->update(['estado' => 'pagada']);

        return back()->with('success', 'Factura marcada como pagada correctamente');
    }

    public function index()
    {
        $facturas = Factura::with('proveedor')
            ->orderBy('fecha_emision', 'desc')
            ->paginate(10);

        return view('admin.facturas.index', compact('facturas'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::where('stock', '>', 0)->get();

        return view('admin.facturas.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'numero_factura' => 'required|unique:facturas',
            'fecha_emision' => 'required|date',
            'impuestos' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $factura = Factura::create([
                'proveedor_id' => $request->proveedor_id,
                'numero_factura' => $request->numero_factura,
                'fecha_emision' => $request->fecha_emision,
                'impuestos' => $request->impuestos,
                'subtotal' => 0,
                'total' => 0,
                'estado' => 'pendiente',
                'notas' => $request->notas ?? null,
            ]);

            $subtotal = 0;

            foreach ($request->productos as $producto) {
                $precio = $producto['precio_unitario'];
                $cantidad = $producto['cantidad'];
                $descuento = $producto['descuento'] ?? 0;
                $subtotalProducto = ($precio * $cantidad) - $descuento;

                $factura->detalles()->create([
                    'producto_id' => $producto['id'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'descuento' => $descuento,
                    'subtotal' => $subtotalProducto,
                ]);

                $subtotal += $subtotalProducto;
            }

            $impuestosCalculo = $subtotal * ($request->impuestos / 100);
            $total = $subtotal + $impuestosCalculo;

            $factura->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('facturas.show', $factura)
                ->with('success', 'Factura creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(Factura $factura)
    {
        $factura->load('detalles.producto', 'proveedor');
        return view('admin.facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        $proveedores = Proveedor::all();
        $productos = Producto::where('stock', '>', 0)->get();

        return view('admin.facturas.edit', compact('factura', 'proveedores', 'productos'));
    }

    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'numero_factura' => 'required|unique:facturas,numero_factura,' . $factura->id,
            'fecha_emision' => 'required|date',
            'impuestos' => 'required|numeric|min:0'
        ]);

        $factura->update($request->only([
            'proveedor_id',
            'numero_factura',
            'fecha_emision',
            'fecha_vencimiento',
            'impuestos',
            'notas'
        ]));

        return redirect()->route('facturas.show', $factura)
            ->with('success', 'Factura actualizada correctamente');
    }

    public function pdf(Factura $factura)
    {
        $factura->load('detalles.producto', 'proveedor');

        $pdf = PDF::loadView('admin.facturas.pdf', compact('factura'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("factura-{$factura->numero_factura}.pdf");
    }

    public function destroy(Factura $factura)
    {
        DB::beginTransaction();

        try {
            // Revertir stock
            foreach ($factura->detalles as $detalle) {
                Producto::where('id', $detalle->producto_id)
                    ->decrement('stock', $detalle->cantidad);
            }

            $factura->detalles()->delete();
            $factura->delete();

            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success', 'Factura eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la factura: ' . $e->getMessage());
        }
    }
}
