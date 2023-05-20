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
        Schema::create('article_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70);
            $table->string('description', 290)->nullable();
            $table->enum('visibility', ['Private', 'Public'])->default('Public');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_lists');
    }
};
