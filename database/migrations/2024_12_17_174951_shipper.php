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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id(); // Auto-increment column for id
            $table->unsignedBigInteger('user_id'); // Unsigned Big Integer for user_id
            $table->string('device_mapping'); // VARCHAR(255) for device_mapping
            $table->timestamps(); // Creates both created_at and updated_at columns

            // Foreign Key Constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippers');
    }
};

