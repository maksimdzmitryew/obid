<?php

use Faker\Generator as Faker;

$factory->define(App\Partner::class, function (Faker $faker) {
    return [
        'category_id' => function() {
            return factory(App\Category::class)->create()->id;
        },
        'festival_id' => function() {
            return factory(App\Festival::class)->create()->id;
        },
        'url' => $faker->url
    ];
});
