<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicle_entries', function (Blueprint $table) {
        // Verificar si la columna existe antes de intentar eliminarla
        if (Schema::hasColumn('vehicle_entries', 'espacio_id')) {
            // Eliminar la restricción solo si existe
            DB::statement('ALTER TABLE vehicle_entries DROP CONSTRAINT IF EXISTS vehicle_entries_espacio_id_foreign');
            $table->dropColumn('espacio_id');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_entries', function (Blueprint $table) {
        $table->foreignId('espacio_id')->nullable()->constrained('parking_spaces')->onDelete('set null');
    });
    }
};
