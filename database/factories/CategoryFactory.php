<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Category::class, function (Faker $faker) use ($fakerCH) {
    return [
        'type' => 'news',
        'en' => [
            'name' => $faker->word,
            'slug' => $faker->slug,
        ],
        'de' => [
            'name' => $fakerCH->word,
            'slug' => $faker->slug
        ],
    ];
});
