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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-increment column for id
            $table->text('password'); // Text field for password
            $table->string('fullname'); // String for fullname
            $table->string('username')->unique(); // Unique username
            $table->unsignedBigInteger('role_id'); // Unsigned Big Integer for role_id
            $table->unsignedBigInteger('address_id'); // Unsigned Big Integer for address_id
            $table->timestamps(); // Automatically generates created_at and updated_at columns

            // Foreign Key Constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        });

        // Create the password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary(); // Primary key on username
            $table->string('token'); // Token for password reset
            $table->timestamp('created_at')->nullable(); // Created_at for token expiration
        });

        // Create the sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Primary key for session ID
            $table->foreignId('user_id')->nullable()->index(); // Foreign key for user_id, nullable for guest users
            $table->string('ip_address', 45)->nullable(); // IP address field, max length for IPv6
            $table->text('user_agent')->nullable(); // User agent field to store browser information
            $table->longText('payload'); // Store session payload
            $table->integer('last_activity')->index(); // Last activity timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
