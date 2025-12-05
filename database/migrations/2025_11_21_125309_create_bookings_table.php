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
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->nullable();
            $table->bigInteger('locationId')->nullable();
            $table->bigInteger('scheduleId')->nullable();
            $table->bigInteger('scheduleBookingId')->nullable();
            $table->bigInteger('tableId')->nullable();
            $table->string('tableName')->nullable();
            $table->string('locationName')->nullable();
            $table->string('bookingRef')->nullable();
            $table->string('fullName')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('guests')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
