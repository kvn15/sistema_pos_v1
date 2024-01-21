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
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('ruc',15);
            $table->string('razon_social',350);
            $table->string('domicilio_fiscal',350)->nullable();
            $table->string('nombre_comercial',350)->nullable();
            $table->string('sIdUbigeo')->nullable();
            $table->string('ubigeo')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefono_fijo')->nullable();
            $table->string('email')->nullable();
            $table->string('pagina_web')->nullable();
            $table->double('iva', 12, 2)->nullable();
            $table->double('descuento_maximo', 12, 2)->nullable();
            $table->text('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
