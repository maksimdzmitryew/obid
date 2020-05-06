<?php

use Faker\Generator as Faker;

$factory->define(App\PartnerType::class, function (Faker $faker) {
    return [
        'en' => [
            'name' => $faker->word,
        ],
        'de' => [
            'name' => $faker->word,
        ],
    ];
});
