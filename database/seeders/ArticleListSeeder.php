<?php

namespace Database\Seeders;

use App\Models\ArticleList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArticleList::factory()->count(20)->create();
    }
}
