<?php

use Faker\Generator as Faker;

$factory->define(App\NewsCategory::class, function (Faker $faker) {
    return [
        'en' => [
            'name' => $faker->word,
            'slug' => $faker->unique()->slug
        ],
        'de' => [
            'name' => $faker->word,
            'slug' => $faker->unique()->slug
        ]
    ];
});
