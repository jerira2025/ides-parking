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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('archivo');
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->foreignId('tipo_documento_id')->constrained('tipos_documento')->onDelete('cascade');
            $table->date('fecha_documento');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('confidencial')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
