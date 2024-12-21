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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp', 15)->nullable(false);
            $table->text('street')->nullable(false);
            $table->string('sub_district', 50)->nullable(false);
            $table->string('district', 50)->nullable(false);
            $table->string('city', 50)->nullable(false);
            $table->string('province', 50)->nullable(false);
            $table->string('postal_code', 6)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
