<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Post::class, function (Faker $faker) use ($fakerCH) {
    return [
        'category_id' => function() {
            return factory(\App\Category::class)->create(['type' => 'news'])->id;
        },
        'festival_id' => function() {
            return factory(\App\Festival::class)->create()->id;
        },
        'promoting' => rand(0, 1),
        'type' => 'news',
        'en' => [
            'slug' => $faker->unique()->slug,
            'title' => $faker->sentence,
            'excerpt' => $faker->paragraph,
            'body' => $faker->paragraphs(3, true),
            'meta_title' => $faker->word,
            'meta_description' => $faker->sentence,
            'meta_keywords' => $faker->word,
        ],
        'de' => [
            'slug' => $fakerCH->unique()->slug,
            'title' => $fakerCH->sentence,
            'excerpt' => $fakerCH->paragraph,
            'body' => $fakerCH->paragraphs(3, true),
            'meta_title' => $fakerCH->word,
            'meta_description' => $fakerCH->sentence,
            'meta_keywords' => $fakerCH->word,
        ],
    ];
});
