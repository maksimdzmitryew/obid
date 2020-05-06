<?php

use Faker\Generator as Faker;

$factory->define(App\Place::class, function (Faker $faker) {
    return [
        'city_id' => function() {
            return factory(\App\City::class)->create()->id;
        },
        'en' => [
            'name' => $faker->word
        ],
        'de' => [
            'name' => $faker->word
        ],
    ];
});
