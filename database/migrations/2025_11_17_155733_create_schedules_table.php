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
     * 
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->nullable();
            $table->bigInteger('locationId')->nullable();
            $table->string('locationName')->nullable();
            $table->string('status')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->longText('description')->nullable();
            $table->mediumInteger('tablesTotal')->nullable();
            $table->mediumInteger('tablesTaken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
