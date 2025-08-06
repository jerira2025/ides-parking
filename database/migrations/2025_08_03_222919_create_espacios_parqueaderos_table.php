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
        Schema::create('espacios_parqueadero', function (Blueprint $table) {
    $table->id();
    $table->string('numero_espacio')->unique();
    $table->enum('estado', ['disponible', 'ocupado'])->default('disponible');
    $table->unsignedBigInteger('zona_id');
    $table->unsignedBigInteger('tipo_vehiculo_id'); // el tipo preferido

    $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
    $table->foreign('tipo_vehiculo_id')->references('id')->on('tipo_vehiculos')->onDelete('cascade');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacios_parqueaderos');
    }
};
