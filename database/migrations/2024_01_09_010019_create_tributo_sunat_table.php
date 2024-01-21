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
        Schema::create('tributo_sunat', function (Blueprint $table) {
            $table->id();
            $table->string('cod_tributo');
            $table->string('tributo');
            $table->string('cod_internacional');
            $table->string('nombre');
            $table->double('valor_tri', 12, 2)->nullable();
            $table->tinyInteger('state')->default(1)->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tributo_sunat');
    }
};
