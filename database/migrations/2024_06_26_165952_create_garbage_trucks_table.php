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
            $table->enum('type', ['Dump Truck (Besar)', 'Dump Truck (Kecil)']);
            $table->timestamps();
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
