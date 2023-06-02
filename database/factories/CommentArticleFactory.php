<?php

namespace Database\Factories;

use Faker\Factory as faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentArticle>
 */
class CommentArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = faker::create();
        $user = DB::table('users')->pluck('id');
        $user_id = $faker->randomElement($user);
        $article = DB::table('articles')->pluck('id');
        $article_id = $faker->randomElement($article);
        return [
            'content' => $faker->text(),
            'user_id' => $user_id,
            'article_id' => $article_id,
            'status' => Arr::random(['Published', 'Rejected']),
        ];
    }
}
