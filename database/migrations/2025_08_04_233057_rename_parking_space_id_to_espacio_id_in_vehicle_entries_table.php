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
        $table->renameColumn('parking_space_id', 'espacio_id');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_entries', function (Blueprint $table) {
        $table->renameColumn('espacio_id', 'parking_space_id');
    });
    }
};
