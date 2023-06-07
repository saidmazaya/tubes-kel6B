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
            $table->id('id');
            $table->string('username', 30)->unique();
            $table->string('name', 50);
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->string('bio')->nullable();
            $table->text('about')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    //sql query 
    // CREATE TABLE users (
    //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //     username VARCHAR(30) UNIQUE,
    //     name VARCHAR(50),
    //     password VARCHAR(255),
    //     email VARCHAR(255) UNIQUE,
    //     email_verified_at TIMESTAMP NULL,
    //     image VARCHAR(255) NULL,
    //     bio VARCHAR(255) NULL,
    //     about TEXT NULL,
    //     remember_token VARCHAR(100),
    //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    // );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
