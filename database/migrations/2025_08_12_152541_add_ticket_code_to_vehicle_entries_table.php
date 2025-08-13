<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicle_entries', function (Blueprint $table) {
            $table->uuid('ticket_code')->nullable()->unique()->after('entry_time');
        });
    }

    public function down()
    {
        Schema::table('vehicle_entries', function (Blueprint $table) {
            $table->dropColumn('ticket_code');
        });
    }
};
