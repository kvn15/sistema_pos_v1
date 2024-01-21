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
        Schema::create('boleta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('fecha_emision', $precision = 0);
            $table->dateTime('firma_digital', $precision = 0)->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresa');
            $table->unsignedBigInteger('voucher_id');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
            $table->string('boleta_num');
            $table->unsignedBigInteger('numeracion');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('codigo_tipo_15_1')->default('1001');
            $table->double('monto', 12, 2);
            $table->double('descuento', 12, 2);
            $table->double('tipo_cambio', 12, 2)->nullable();
            $table->double('sumatoria_igv', 12, 2);
            $table->double('tasa_igv', 12, 2);
            $table->unsignedBigInteger('tributo_sunat_id');
            $table->foreign('tributo_sunat_id')->references('id')->on('tributo_sunat');
            $table->double('importe_total', 12, 2);
            $table->string('codigo_leyenda')->default('1000');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencys');
            $table->unsignedBigInteger('estado_comprobante_id');
            $table->foreign('estado_comprobante_id')->references('id')->on('estado_comprobante');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pago');
            $table->double('monto_pago', 12, 2);
            $table->double('vuelto_pago', 12, 2)->default(0.00);
            $table->double('efectivo', 12, 2)->default(0.00);
            $table->double('visa', 12, 2)->default(0.00);
            $table->double('yape', 12, 2)->default(0.00);
            $table->double('plin', 12, 2)->default(0.00);
            $table->double('mastercad', 12, 2)->default(0.00);
            $table->double('deposito', 12, 2)->default(0.00);
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boleta');
    }
};
