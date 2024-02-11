<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $title = $faker->sentence(6);

        foreach(range(1,25) as $item) {
            Article::create([
                'title' => $title,
                'content' => $faker->paragraph(10),
                'status' => $faker->randomElement([true, false]),
                'image' => $faker->imageUrl(640, 480),
                'category_id' => $faker->numberBetween(1,10),
                'user_id' => $faker->numberBetween(1,2) // isteğe göre değişir.
            ]);
        }
    }
}
