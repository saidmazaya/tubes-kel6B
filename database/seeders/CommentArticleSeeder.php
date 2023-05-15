<?php

namespace Database\Seeders;

use App\Models\CommentArticle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('comment_articles')->truncate();

        CommentArticle::factory()->count(20)->create();
    }
}
