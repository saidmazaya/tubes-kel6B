<?php

namespace Database\Seeders;

use App\Models\CommentArticle;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommentArticle::factory()->count(20)->create();
    }
}
