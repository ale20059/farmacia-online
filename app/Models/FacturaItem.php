<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturaItem extends Model
{
    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    protected static function booted()
    {
        static::saving(function ($item) {
            $item->subtotal = $item->cantidad * $item->precio_unitario;
        });
    }
}
