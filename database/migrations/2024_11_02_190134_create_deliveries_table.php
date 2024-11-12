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
            $table->string('delivery_number');
            $table->string('company_name');
            $table->integer('shipper_id');
            $table->string('status');
            $table->date('delivery_date');
            $table->date('receive_date')->nullable();
            $table->string('confirmation_code');
            $table->timestamp('created_at');
            $table->string('created_by');
            $table->timestamp('updated_at');
            $table->string('updated_by');
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
