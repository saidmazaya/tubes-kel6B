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
        Schema::table('comment_articles', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('article_id');
            $table->foreign('parent_id')->references('id')->on('comment_articles')->onDelete('cascade');
        });

        //query sql 

        // ALTER TABLE comment_articles
        // ADD parent_id BIGINT UNSIGNED NULL AFTER article_id,
        // ADD CONSTRAINT comment_articles_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES comment_articles(id) ON DELETE CASCADE;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_articles', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
