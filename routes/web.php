<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthEmpleadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FacturaDetalleController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación para empleados
Route::prefix('empleado')->group(function () {
    Route::get('/login', [AuthEmpleadoController::class, 'showLoginForm'])->name('empleado.login');
    Route::post('/login', [AuthEmpleadoController::class, 'login'])->name('empleado.login.post');
    Route::post('/logout', [AuthEmpleadoController::class, 'logout'])->name('empleado.logout');
});

// Rutas protegidas para empleados
Route::middleware(['auth:empleado'])->group(function () {
    // Dashboard
    Route::get('/empleado/dashboard', [DashboardController::class, 'index'])->name('empleado.dashboard');

    // CRUDs
    Route::resource('/productos', ProductoController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('proveedores', ProveedorController::class);

    // Administración de pedidos
    Route::prefix('admin')->group(function () {
        Route::get('/pedidos', [PedidoAdminController::class, 'index'])->name('admin.pedidos.index');
        Route::get('/pedidos/{id}', [PedidoAdminController::class, 'show'])->name('admin.pedidos.show');
        Route::get('/pedidos/{id}/factura', [PedidoAdminController::class, 'factura'])->name('admin.pedidos.factura');
    });
});

// Rutas de autenticación para clientes
Route::prefix('cliente')->group(function () {
    Route::get('/login', [ClienteAuthController::class, 'showLogin'])->name('cliente.login');
    Route::get('/register', [ClienteAuthController::class, 'showRegister'])->name('cliente.register');
    Route::post('/register', [ClienteAuthController::class, 'register'])->name('cliente.register.post');
    Route::post('/login', [ClienteAuthController::class, 'login'])->name('cliente.login.post');
    Route::post('/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');
});

// Rutas protegidas para clientes
Route::middleware('auth.cliente')->group(function () {
    // Tienda
    Route::get('/cliente/tienda', [TiendaController::class, 'index'])->name('cliente.tienda');

    // Carrito
    Route::prefix('cliente/carrito')->group(function () {
        Route::get('/', [CarritoController::class, 'verCarrito'])->name('cliente.carrito');
        Route::post('/agregar/{producto}', [TiendaController::class, 'agregarAlCarrito'])->name('cliente.carrito.agregar');
        Route::post('/eliminar/{item}', [CarritoController::class, 'eliminar'])->name('cliente.carrito.eliminar');
        Route::post('/checkout', [CarritoController::class, 'checkout'])->name('cliente.carrito.checkout');
    });
});

// Ruta de factura accesible sin autenticación
Route::get('/cliente/factura/{id}', [CarritoController::class, 'factura'])->name('cliente.factura');






// En routes/web.php, añade esta ruta genérica (temporal):
Route::post('/logout', function () {
    if (auth('empleado')->check()) {
        return redirect()->route('empleado.logout');
    } else {
        return redirect()->route('cliente.logout');
    }
})->name('logout');

// Rutas para Proveedores
Route::resource('proveedores', ProveedorController::class);

// Rutas para Facturas (ejemplo básico)
Route::get('/facturas', [FacturaController::class, 'index'])->name('facturas.index');
Route::get('/facturas/create', [FacturaController::class, 'create'])->name('facturas.create');
Route::post('/facturas', [FacturaController::class, 'store'])->name('facturas.store');


Route::middleware(['auth:empleado'])->prefix('admin')->group(function () {
    Route::get('/facturas', [FacturaController::class, 'index'])->name('facturas.index');
    Route::get('/facturas/create', [FacturaController::class, 'create'])->name('facturas.create');
    Route::post('/facturas', [FacturaController::class, 'store'])->name('facturas.store');
    Route::get('/facturas/{factura}', [FacturaController::class, 'show'])->name('facturas.show');
    Route::get('/facturas/{factura}/pdf', [FacturaController::class, 'pdf'])->name('facturas.pdf');
    Route::post('/facturas/{factura}/pagar', [FacturaController::class, 'pagar'])
        ->name('facturas.pagar');
});


Route::middleware(['auth:empleado'])->prefix('admin')->group(function () {
    // ... otras rutas de facturas

    // Rutas para detalles
    Route::post('/facturas/{factura}/detalles', [FacturaDetalleController::class, 'store'])
        ->name('facturas.detalles.store');

    Route::delete('/facturas/{factura}/detalles/{detalle}', [FacturaDetalleController::class, 'destroy'])
        ->name('facturas.detalles.destroy');
});
