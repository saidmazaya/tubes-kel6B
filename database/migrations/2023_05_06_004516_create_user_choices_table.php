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
        Schema::create('user_choices', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->primary(['user_id', 'tag_id']);
            $table->timestamps();
        });

        //query sql

        // CREATE TABLE user_choices (
        //     user_id BIGINT UNSIGNED,
        //     tag_id BIGINT UNSIGNED,
        //     PRIMARY KEY (user_id, tag_id),
        //     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        //     FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_choices');
    }
};
