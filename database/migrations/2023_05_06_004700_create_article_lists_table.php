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
            $table->integer('add_id');
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

        //query sql 

        // CREATE TABLE article_lists (
        //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     add_id INT,
        //     name VARCHAR(70),
        //     description VARCHAR(290) NULL,
        //     visibility ENUM('Private', 'Public') DEFAULT 'Public',
        //     user_id BIGINT UNSIGNED,
        //     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        //     article_id BIGINT UNSIGNED,
        //     FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE ON UPDATE CASCADE,
        //     owner_id BIGINT UNSIGNED,
        //     FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_lists');
    }
};
