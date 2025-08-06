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
        Schema::table('compatibilidades', function (Blueprint $table) {
        $table->unique(['zona_id', 'tipo_vehiculo_id'], 'zona_tipo_unique');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compatibilidades', function (Blueprint $table) {
        $table->dropUnique('zona_tipo_unique');
    });
    }
};
