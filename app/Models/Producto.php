<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'imagen', 'proveedor_id'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    // En app/Models/Producto.php
    public function facturaDetalles()
    {
        return $this->hasMany(FacturaDetalle::class);
    }

    public function facturas()
    {
        return $this->belongsToMany(Factura::class, 'factura_detalles')
            ->using(FacturaDetalle::class)
            ->withPivot(['cantidad', 'precio_unitario', 'descuento', 'subtotal']);
    }

    public function detallePedidos()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}
