<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Factura extends Model
{

    protected $fillable = [
        'proveedor_id',
        'numero_factura',
        'fecha_emision',
        'fecha_vencimiento',
        'subtotal',
        'impuestos',
        'total',
        'estado',
        'notas'
    ];

    protected $casts = [
        'fecha_emision' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Estados posibles
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADA = 'pagada';
    const ESTADO_CANCELADA = 'cancelada';

    /**
     * Relación con el proveedor
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con los detalles/items de la factura
     * (Usando el nombre más descriptivo "detalles" en lugar de "items")
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(FacturaDetalle::class);
    }

    /**
     * Calcula y actualiza los totales de la factura
     */
    public function calcularTotales(): bool
    {
        $this->subtotal = $this->detalles->sum('subtotal');
        $this->total = $this->subtotal + ($this->subtotal * ($this->impuestos / 100));

        return $this->save();
    }

    /**
     * Cambia el estado a "pagada"
     */
    public function marcarComoPagada(): bool
    {
        $this->estado = self::ESTADO_PAGADA;
        return $this->save();
    }

    /**
     * Accesor para el estado formateado
     */
    protected function estadoFormateado(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->estado)
        );
    }

    /**
     * Accesor para la fecha de emisión formateada
     */
    protected function fechaEmisionFormateada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fecha_emision->format('d/m/Y')
        );
    }

    /**
     * Query Scope para facturas pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    /**
     * Query Scope para facturas pagadas
     */
    public function scopePagadas($query)
    {
        return $query->where('estado', self::ESTADO_PAGADA);
    }
}
