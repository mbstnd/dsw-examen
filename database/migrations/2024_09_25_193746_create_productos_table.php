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
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->string('sku')->unique();
            $table->string('nombre');
            $table->string('descripcion_corta', 255); // Descripción corta con un límite de caracteres
            $table->text('descripcion_larga');
            $table->string('imagen')->nullable(); // Imagen del producto, puede ser nulo
            $table->decimal('precio_neto', 10, 2); // Precio neto (sin impuestos)
            $table->decimal('precio_venta', 10, 2); // Precio de venta (incluye el IVA del 19%)
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->integer('stock_bajo'); // Stock bajo (alerta)
            $table->integer('stock_alto'); // Stock alto (alerta)
            $table->timestamps(); // Timestamps (created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
