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
        Schema::create('delivery_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id')->nullable(false);
            $table->string('recipient_name')->nullable(false);
            $table->unsignedBigInteger('address_id')->nullable(false);
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('deliveries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onUpdate('cascade')->onDelete('cascade');

            $table->index('address_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_recipients');
    }
};

