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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('garbage_truck_id');
            $table->timestamps();

            $table->foreign('route_id')
            ->references('id')
            ->on('routes')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('garbage_truck_id')
            ->references('id')
            ->on('garbage_trucks')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
