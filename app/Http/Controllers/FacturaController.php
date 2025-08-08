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
    public function pagar($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->estado = 'pagada';
        $factura->save();

        return redirect()->back()->with('success', 'Factura pagada correctamente.');
    }

    public function pdf(Factura $factura)
    {
        $factura->load('detalles.producto', 'proveedor');

        $pdf = Pdf::loadView('admin.facturas.pdf', compact('factura'))
            ->setPaper([0, 0, 226.77, 600], 'portrait');

        return $pdf->download("factura-{$factura->numero_factura}.pdf");
    }

    public function index()
    {
        $facturas = Factura::with('proveedor')->orderBy('fecha_emision', 'desc')->paginate(10);
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
            'numero_factura' => 'required|unique:facturas',
            'fecha_emision' => 'required|date',
            'impuestos' => 'required|numeric|min:0',
            'moneda' => 'required|in:GTQ,USD',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $factura = Factura::create([
                'numero_factura' => $request->numero_factura,
                'fecha_emision' => $request->fecha_emision,
                'impuestos' => $request->impuestos,
                'moneda' => $request->moneda,
                'subtotal' => 0,
                'total' => 0,
                'estado' => 'pendiente',
                'notas' => $request->notas ?? null,
            ]);

            $subtotal = 0;

            foreach ($request->productos as $producto) {
                $subtotalProducto = ($producto['precio_unitario'] * $producto['cantidad']) - ($producto['descuento'] ?? 0);

                FacturaDetalle::create([
                    'factura_id' => $factura->id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $producto['precio_unitario'],
                    'descuento' => $producto['descuento'] ?? 0,
                    'subtotal' => $subtotalProducto,
                ]);

                $subtotal += $subtotalProducto;
            }

            $total = $subtotal + ($subtotal * ($request->impuestos / 100));

            $factura->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('facturas.show', $factura)->with('success', 'Factura creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar la factura: ' . $e->getMessage());
        }
    }

    public function show(Factura $factura)
    {
        $factura->load('detalles.producto', 'proveedor');
        return view('admin.facturas.show', compact('factura'));
    }
}
