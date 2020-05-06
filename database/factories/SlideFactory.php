<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Slide::class, function (Faker $faker) use ($fakerCH) {
    return [
        'slider_id' => function() {
            return factory(App\Slider::class)->create()->id;
        },
        'position' => rand(1, 10),
        'en' => [
            'upper_title' => $faker->sentence,
            'title' => $faker->sentence,
            'description' => $faker->sentence,
            'button_text' => $faker->word,
            'button_url' => $faker->url
        ],
        'de' => [
            'upper_title' => $fakerCH->sentence,
            'title' => $fakerCH->sentence,
            'description' => $fakerCH->sentence,
            'button_text' => $fakerCH->word,
            'button_url' => $fakerCH->url
        ]
    ];
});
