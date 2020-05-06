<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Festival::class, function (Faker $faker) use ($fakerCH) {
    return [
        'active' => 0,
        'year' => null,
        'en' => [
            'name' => $faker->word,
            'slug' => $faker->unique()->slug,
            'program_description' => $faker->paragraph,
            'about_festival' => $faker->paragraph,
        ],
        'de' => [
            'name' => $fakerCH->word,
            'slug' => $fakerCH->unique()->slug,
            'program_description' => $fakerCH->paragraph,
            'about_festival' => $fakerCH->paragraph,
        ]
    ];
});
