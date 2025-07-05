<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Empleado;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $totalPedidos = Pedido::count();
        $totalVentas = Pedido::sum('total');
        $totalEmpleados = Empleado::count();

        return view('empleados.dashboard', compact(
            'totalProductos', 'totalPedidos', 'totalVentas', 'totalEmpleados'
        ));
    }
}
