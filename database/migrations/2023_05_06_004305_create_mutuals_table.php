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
        Schema::create('mutuals', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('following_user_id');
            $table->foreign('following_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['user_id', 'following_user_id']);
            $table->timestamps();

            //query sql

            // CREATE TABLE mutuals (
            //     user_id BIGINT UNSIGNED,
            //     following_user_id BIGINT UNSIGNED,
            //     PRIMARY KEY (user_id, following_user_id),
            //     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            //     FOREIGN KEY (following_user_id) REFERENCES users(id) ON DELETE CASCADE,
            //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            // );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutuals');
    }
};
