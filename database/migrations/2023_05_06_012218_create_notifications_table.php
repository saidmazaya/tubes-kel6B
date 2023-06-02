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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('mutual_id')->nullable();
            $table->foreign('mutual_id')->references('following_user_id')->on('mutuals')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('clap_article_id')->nullable();
            $table->foreign('clap_article_id')->references('id')->on('clap_articles')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('clap_comment_article_id')->nullable();
            $table->foreign('clap_comment_article_id')->references('id')->on('clap_comment_articles')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('comment_article_id')->nullable();
            $table->foreign('comment_article_id')->references('id')->on('comment_articles')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
