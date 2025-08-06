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
            Schema::create('tarifas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tipo_vehiculo_id')->constrained('tipo_vehiculos')->onDelete('cascade');
        $table->foreignId('zona_id')->nullable()->constrained('zonas')->onDelete('cascade');
        $table->decimal('precio_hora', 10, 2);
        $table->decimal('precio_dia', 10, 2)->nullable(); // opcional
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
