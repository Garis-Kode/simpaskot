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
            $table->enum('type', ['TPA', 'TPS', 'Pool']);
            $table->string('address');
            $table->float('latitude');
            $table->float('longitude');
            $table->float('volume')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('latitude');
            $table->index('longitude');
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
