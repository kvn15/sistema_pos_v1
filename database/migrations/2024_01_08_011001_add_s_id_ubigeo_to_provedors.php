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
        Schema::table('provedors', function (Blueprint $table) {
            $table->string('sIdUbigeo', 25)->nullable()->after('ubigeo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provedors', function (Blueprint $table) {
            //
        });
    }
};
