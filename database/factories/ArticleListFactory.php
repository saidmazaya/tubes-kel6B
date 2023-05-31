<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Faker\Factory as faker;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleList>
 */
class ArticleListFactory extends Factory
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
        $owner = $users->random();
        $article = Article::all();
        $articles = $article->random();
        return [
            'name' => $faker->word(),
            'description' => $faker->text(),
            'visibility' => Arr::random(['Private', 'Public']),
            'user_id' => $user->id,
            'add_id' => 1,
            'article_id' => $articles->id,
            'owner_id' => $owner->id
        ];
    }
}
