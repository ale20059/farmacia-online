<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $fillable = ['cliente_id', 'producto_id', 'cantidad'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
