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
        Schema::table('vehicle_entries', function (Blueprint $table) {
        $table->foreignId('espacio_id')->nullable()->constrained('espacios_parqueadero')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_entries', function (Blueprint $table) {
        $table->dropForeign(['espacio_id']);
        $table->dropColumn('espacio_id');
    });
    }
};
