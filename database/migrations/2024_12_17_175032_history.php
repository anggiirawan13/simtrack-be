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
        Schema::create('delivery_history_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id')->nullable(false);
            $table->string('latitude', 20)->nullable(false);
            $table->string('longitude', 20)->nullable(false);
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('deliveries')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_history_locations');
    }
};
