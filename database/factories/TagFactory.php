<?php

namespace Database\Factories;

use Faker\Factory as faker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = faker::create();
        $name = Str::random(10);
        return [
            'name' => $name,
            'slug' => Str::slug($name, '-'),
        ];
    }
}
