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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_producto_id');
            $table->foreign('tipo_producto_id')->references('id')->on('tipo_products');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categories');
            $table->string('codigo_barras', 50)->nullable();
            $table->string('nombre_producto', 300);
            $table->string('detalle_producto', 300);
            $table->string('principio_activo', 350)->nullable();
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->string('marca_otro')->nullable();
            $table->unsignedBigInteger('provedor_id')->nullable();;
            $table->foreign('provedor_id')->references('id')->on('provedors');
            $table->unsignedBigInteger('stock_inicial');
            $table->unsignedBigInteger('stock_final');
            $table->unsignedBigInteger('stock_limite')->nullable();
            $table->double('price_compra', 12, 2)->nullable();
            $table->text('imagen_producto')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('lote', 75)->nullable();
            $table->string('registro_sanitario',300)->nullable();
            $table->string('presentacion',300)->nullable();
            $table->unsignedBigInteger('tributo_sunat_id')->nullable();
            $table->foreign('tributo_sunat_id')->references('id')->on('tributo_sunat');
            $table->unsignedBigInteger('laboratorio_id')->nullable();
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');
            $table->tinyInteger('state')->default(1)->unsigned();
            $table->string('laboratorio_otro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
