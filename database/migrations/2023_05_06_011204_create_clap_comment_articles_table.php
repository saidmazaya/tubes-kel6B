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
        Schema::create('clap_comment_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('comment_article_id');
            $table->foreign('comment_article_id')->references('id')->on('comment_articles')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        //query sql

        // CREATE TABLE clap_comment_articles (
        //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     user_id BIGINT UNSIGNED,
        //     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        //     comment_article_id BIGINT UNSIGNED,
        //     FOREIGN KEY (comment_article_id) REFERENCES comment_articles(id) ON DELETE CASCADE ON UPDATE CASCADE,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clap_comment_articles');
    }
};
