<?php

use Faker\Generator as Faker;

$factory->define(App\Slider::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
