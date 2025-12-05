<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 
     * Run the migrations.
     *
     **/
    public function up(): void
    {
        Schema::create('schedule_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->nullable();
            $table->bigInteger('locationId')->nullable();
            $table->bigInteger('tableId')->nullable();
            $table->bigInteger('scheduleId')->nullable();
            $table->string('locationName')->nullable();
            $table->string('tableName')->nullable();
            $table->string('quantity')->nullable();
            $table->string('taken')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_bookings');
    }
};
