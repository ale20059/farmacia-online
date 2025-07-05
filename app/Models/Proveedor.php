<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // importante si la migración es "proveedores"

    protected $fillable = ['nombre', 'telefono', 'correo', 'direccion'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
