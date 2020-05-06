<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Book::class, function (Faker $faker) use ($fakerCH) {
    return [
        'festival_id' => function() {
            return factory(App\Festival::class)->create()->id;
        },
        'url' => $faker->url,
        'api_code' => $faker->url, 
        'en' => [
            'name' => $faker->word,
            'slug' => $faker->slug,
            'excerpt' => $faker->sentence,
            'volume' => '256 pages with special full-color project inserts.',
            'description' => $faker->sentence,
            'meta_title' => $faker->word,
            'meta_keywords' => $faker->sentence,
            'meta_description' => $faker->paragraph,
        ],
        'de' => [
            'name' => $fakerCH->word,
            'slug' => $fakerCH->slug,
            'excerpt' => $fakerCH->sentence,
            'volume' => '256 Seiten mit speziellen Vollfarb-Projekteinsätzen.',
            'description' => $fakerCH->sentence,
            'meta_title' => $fakerCH->word,
            'meta_keywords' => $fakerCH->sentence,
            'meta_description' => $fakerCH->paragraph,
        ]
    ];
});
