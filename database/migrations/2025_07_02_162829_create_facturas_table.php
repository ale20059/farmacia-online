<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->string('numero_factura')->unique();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0)->change();
            $table->decimal('impuestos', 5, 2); // Porcentaje
            $table->decimal('total', 10, 2)->default(0)->change();
            $table->enum('estado', ['pendiente', 'pagada', 'cancelada'])->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
