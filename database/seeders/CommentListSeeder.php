<?php

namespace Database\Seeders;

use App\Models\CommentList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommentList::factory()->count(20)->create();
    }
}
