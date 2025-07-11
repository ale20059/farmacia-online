<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturaDetalle extends Model
{
    protected $table = 'factura_detalles'; // Si prefieres este nombre

    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal'
    ];

    // Relación con Factura
    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    // Relación con Producto
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    // Calcula el subtotal automáticamente
    protected static function booted()
    {
        static::saving(function ($detalle) {
            $detalle->subtotal = ($detalle->precio_unitario * $detalle->cantidad) - $detalle->descuento;
        });
    }
}
