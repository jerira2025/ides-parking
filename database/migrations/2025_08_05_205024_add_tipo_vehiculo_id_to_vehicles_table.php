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
        Schema::table('vehicles', function (Blueprint $table) {
        $table->unsignedBigInteger('tipo_vehiculo_id')->nullable()->after('plate');
        $table->foreign('tipo_vehiculo_id')->references('id')->on('tipo_vehiculos');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
        $table->dropForeign(['tipo_vehiculo_id']);
        $table->dropColumn('tipo_vehiculo_id');
    });
    }
};
