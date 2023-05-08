<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Factory as faker;
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
        $user = DB::table('users')->pluck('id');
        $user_id = $faker->randomElement($user);
        $title = $faker->sentence();
        return [
            'title' => $faker->sentence(),
            'description' => $faker->paragraph(1),
            'content' => $faker->text(),
            'duration' => rand(5,20),
            'author_id' => $user_id,
            'tag_id' => rand(1,20),
        ];
    }
}
