<?php

use Faker\Generator as Faker;

$factory->define(App\Setting::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'value' => $faker->word,
        'is_translatable' => 0,
    ];
});
