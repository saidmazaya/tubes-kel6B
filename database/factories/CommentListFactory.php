<?php

// namespace Database\Factories;

// use Faker\Factory as faker;
// use Illuminate\Support\Arr;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Eloquent\Factories\Factory;

// /**
//  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentList>
//  */
// class CommentListFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array<string, mixed>
//      */
//     public function definition(): array
//     {
//         $faker = faker::create();
//         $user = DB::table('users')->pluck('id');
//         $user_id = $faker->randomElement($user);
//         $article_list = DB::table('article_lists')->pluck('id');
//         $article_list_id = $faker->randomElement($article_list);
//         return [
//             'content' => $faker->text(),
//             'user_id' => $user_id,
//             'article_list_id' => $article_list_id,
//             'status' => Arr::random(['Published', 'Rejected']),
//         ];
//     }
// }
