<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Media::class, function (Faker $faker) use ($fakerCH) {
    return [
        'festival_id' => function() {
            return factory(App\Festival::class)->create()->id;
        },
        'promoting' => rand(0, 1),
        'en' => [
            'author' => $faker->name,
            'title' => $faker->word,
            'description' => $faker->sentence,
        ],
        'de' => [
            'author' => $fakerCH->name,
            'title' => $fakerCH->word,
            'description' => $fakerCH->sentence,
        ],
    ];
});
