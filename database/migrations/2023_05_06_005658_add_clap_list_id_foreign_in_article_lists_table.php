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
        Schema::table('article_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('clap_list_id')->after('owner_id');
            $table->foreign('clap_list_id')->references('id')->on('clap_lists')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_lists', function (Blueprint $table) {
            $table->dropForeign(['clap_list_id']);
            $table->dropColumn('clap_list_id');
        });
    }
};
