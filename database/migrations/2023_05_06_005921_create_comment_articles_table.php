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
        Schema::create('comment_articles', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('status', ['Published', 'Rejected'])->default('Published');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->timestamps();
        });

        //query sql

        // CREATE TABLE comment_articles (
        //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     content TEXT,
        //     status ENUM('Published', 'Rejected') DEFAULT 'Published',
        //     user_id BIGINT UNSIGNED,
        //     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
        //     article_id BIGINT UNSIGNED,
        //     FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        // );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_articles');
    }
};
