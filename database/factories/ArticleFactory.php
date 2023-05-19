<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Faker\Factory as faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = faker::create();
        $users = User::all();
        $user = $users->random();
        $title = $faker->sentence();
        $tags = Tag::all();
        $tag = $tags->random();
        return [
            'title' => $title,
            'description' => $faker->paragraph(1),
            'content' => $faker->text(),
            'duration' => rand(5,20),
            'slug' => $user->username. '_' . Str::slug($title, '-'). '-' . rand(1000000, 9999999),
            'author_id' => $user->id,
            'tag_id' => $tag->id,
            'status' => Arr::random(['Draft', 'Published', 'Rejected']),
        ];
    }
}
