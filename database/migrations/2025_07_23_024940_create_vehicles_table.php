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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('plate')->unique(); // Matrícula
            $table->enum('type', ['car', 'motorcycle', 'truck', 'bus', 'other'])->default('car'); // Tipo de vehículo
            $table->string('brand')->nullable(); // Marca (Toyota, Yamaha...)
            $table->string('model')->nullable(); // Modelo (Corolla, FZ, etc.)
            $table->string('color')->nullable(); // Color

            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete(); // Si manejas usuarios registrados

            $table->boolean('is_active')->default(true); // Para desactivar vehículos sin borrarlos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
