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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->text('content');
            $table->string('image')->nullable();
            $table->integer('duration');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('restrict');
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('restrict');
            $table->enum('status', ['Draft', 'Pending', 'Published', 'Rejected'])->default('Draft');
            $table->timestamps();
        });
    }

    //query sql

    // CREATE TABLE articles (
    //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //     title VARCHAR(255),
    //     description VARCHAR(255),
    //     content TEXT,
    //     image VARCHAR(255) NULL,
    //     duration INT,
    //     author_id BIGINT UNSIGNED,
    //     FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT,
    //     tag_id BIGINT UNSIGNED NULL,
    //     FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE RESTRICT,
    //     status ENUM('Draft', 'Pending', 'Published', 'Rejected') DEFAULT 'Draft',
    //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    // );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
