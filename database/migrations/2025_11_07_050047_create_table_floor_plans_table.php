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
        Schema::create('table_floor_plans', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('userId')->nullable();
            $table->string('name')->nullable();
            $table->longText('d')->nullable();
            $table->mediumText('details')->nullable();
            $table->string('floor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_floor_plans');
    }
};
