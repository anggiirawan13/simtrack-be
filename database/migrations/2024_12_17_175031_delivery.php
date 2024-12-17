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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id(); // Auto-increment column for id
            $table->string('delivery_number'); // VARCHAR(255) for delivery_number
            $table->string('company_name'); // VARCHAR(255) for company_name
            $table->unsignedBigInteger('shipper_id'); // Unsigned Big Integer for shipper_id
            $table->unsignedBigInteger('status_id'); // Unsigned Big Integer for status_id
            $table->date('delivery_date'); // Date for delivery_date
            $table->date('receive_date')->nullable(); // Nullable date for receive_date
            $table->string('confirmation_code'); // VARCHAR(255) for confirmation_code
            $table->timestamps(); // Creates both created_at and updated_at columns

            // Foreign Key Constraints
            $table->foreign('shipper_id')->references('id')->on('shippers')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('delivery_status')->onDelete('cascade');

            // Indexes
            $table->index('status_id');
            $table->index('shipper_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
