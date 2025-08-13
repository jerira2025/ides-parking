<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parking_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate', 20);
            $table->timestamp('entry_time')->useCurrent();
            $table->timestamp('exit_time')->nullable();
            $table->decimal('hourly_rate', 10, 2)->default(5000);
            $table->decimal('total_hours', 8, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parking_tickets');
    }
};