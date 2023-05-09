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
        Schema::create('comment_lists', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('status', ['Published', 'Pending', 'Rejected'])->default('Pending');
            $table->string('link');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->unsignedBigInteger('article_list_id');
            $table->foreign('article_list_id')->references('id')->on('article_lists')->onDelete('restrict');
            $table->unsignedBigInteger('clap_list_id');
            $table->foreign('clap_list_id')->references('id')->on('clap_lists')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_lists');
    }
};
