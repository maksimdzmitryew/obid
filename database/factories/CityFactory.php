<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\City::class, function (Faker $faker) use ($fakerCH) {
    return [
        'timezone' => collect(timezone_identifiers_list())->random(),
        'en' => [
            'name' => $faker->city,
        ],
        'de' => [
            'name' => $fakerCH->city
        ]
    ];
});
