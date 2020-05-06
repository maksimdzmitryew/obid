<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Press::class, function (Faker $faker) use ($fakerCH) {
    return [
        'type' => 'video',
        'festival_id' => function() {
            return factory(App\Festival::class)->create()->id;
        },
        'gallery_id' => function() {
            return factory(App\Gallery::class)->create()->id;
        },
        'type_id' => function() {
            return factory(App\Category::class)->create(['type' => 'presses']);
        },
        'category_id' => function() {
            return factory(App\Category::class)->create(['type' => 'events']);
        },
        'city_id' => function() {
            return factory(\App\City::class)->create()->id;
        },
        'links' => [
            'youtube' => $faker->url,
            'vimeo' => $faker->url,
        ],
        'en' => [
            'title' => $faker->word,
            'description' => $faker->paragraph,
            'slug' => $faker->unique()->slug,
            'volume' => $faker->word,
        ],
        'de' => [
            'title' => $fakerCH->word,
            'description' => $fakerCH->paragraph,
            'slug' => $fakerCH->unique()->slug,
            'volume' => $faker->word,
        ]
    ];
});
