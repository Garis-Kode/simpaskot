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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('garbage_truck_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('garbage_truck_id')
            ->references('id')
            ->on('garbage_trucks')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
