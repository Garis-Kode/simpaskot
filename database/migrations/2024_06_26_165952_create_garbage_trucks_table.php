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
        Schema::create('garbage_trucks', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate');
            $table->string('driver_name');
            $table->integer('fuel_price');
            $table->float('volume')->nullable();
            $table->enum('type', ['Dump Truck (Besar)', 'Dump Truck (Kecil)']);
            $table->timestamps();

            $table->index('license_plate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garbage_trucks');
    }
};
