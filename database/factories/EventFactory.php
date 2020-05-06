<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Event::class, function (Faker $faker) use ($fakerCH) {
    return [
        'festival_id' => function() {
            return factory(\App\Festival::class)->create()->id;
        },
        'category_id' => function() {
            return factory(\App\Category::class)->create(['type' => 'events'])->id;
        },
        'gallery_id' => function() {
            return factory(\App\Gallery::class)->create()->id;
        },
        'promoting' => rand(0, 1),
        'en' => [
            'slug' => $faker->unique()->slug,
            'title' => $faker->word,
            'description' => $faker->sentence,
            'body' => $faker->paragraph,
            'duration' => 'approximately 1.5 hours',
            'meta_title' => $faker->word,
            'meta_description' => $faker->sentence,
            'meta_keywords' => $faker->word,
        ],
        'de' => [
            'slug' => $fakerCH->unique()->slug,
            'title' => $fakerCH->word,
            'description' => $fakerCH->sentence,
            'body' => $fakerCH->paragraph,
            'duration' => 'ungefähr 1,5 Stunden',
            'meta_title' => $fakerCH->word,
            'meta_description' => $fakerCH->sentence,
            'meta_keywords' => $fakerCH->word,
        ],
    ];
});
