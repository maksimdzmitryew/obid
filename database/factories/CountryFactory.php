<?php
 
use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Country::class, function (Faker $faker) use ($fakerCH) {
    return [
        'en' => [
            'name' => $faker->city,
        ],
        'de' => [
            'name' => $fakerCH->city
        ]
    ];
});
