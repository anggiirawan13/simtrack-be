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
            $table->id(); // Auto-increment column for id
            $table->string('delivery_number'); // VARCHAR(255) for delivery_number
            $table->string('name'); // VARCHAR(255) for name
            $table->unsignedBigInteger('address_id'); // Unsigned Big Integer for address_id
            $table->timestamps(); // Creates both created_at and updated_at columns

            // Foreign Key Constraints
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

            // Index
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

