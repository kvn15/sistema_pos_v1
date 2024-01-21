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
        Schema::create('detail_boleta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boleta_id');
            $table->foreign('boleta_id')->references('id')->on('boleta');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('numero_orden');
            $table->unsignedBigInteger('unidad_medida_id');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
            $table->integer('cantidad_unidad_medida');
            $table->integer('cantidad_venta');
            $table->double('precio_unitario', 12, 2);
            $table->double('descuento', 12, 2);
            $table->double('afectacion_igv', 12, 2);
            $table->double('precio_venta', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_boleta');
    }
};
