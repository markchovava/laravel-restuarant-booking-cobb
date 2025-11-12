<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        Schema::create('table_booking_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tableFloorPlanId')->nullable();
            $table->mediumInteger('userId')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('status')->nullable();
            $table->string('css')->nullable();
            $table->string('fullName')->nullable();
            $table->string('email')->nullable();
            $table->string('numberOfGuests')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_booking_schedules');
    }
};
