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
            $table->id();
            $table->string('delivery_number')->unique()->nullable(false);
            $table->string('company_name')->nullable(false);
            $table->unsignedBigInteger('shipper_id')->nullable(false);
            $table->unsignedSmallInteger('status_id')->nullable(false);
            $table->timestamp('delivery_date')->nullable(false);
            $table->timestamp('receive_date')->nullable(true);
            $table->string('confirmation_code', 8)->nullable(false);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->unsignedBigInteger('updated_by')->nullable(false);

            $table->foreign('shipper_id')->references('id')->on('shippers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('delivery_statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
