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
        Schema::create('dumping_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['TPA', 'TPS']);
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('volume')->nullable();
            $table->integer('area')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dumping_places');
    }
};
