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
            $table->string('name');
            $table->unsignedBigInteger('pool_id');
            $table->unsignedBigInteger('landfill_id');
            $table->timestamps();

            $table->foreign('pool_id')
            ->references('id')
            ->on('pools')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('landfill_id')
            ->references('id')
            ->on('landfills')
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
