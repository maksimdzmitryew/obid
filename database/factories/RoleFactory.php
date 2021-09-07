<?php

use Faker\Generator as Faker;
use Faker\Factory;

$factory->define(App\Role::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'guard_name'  => $faker->name,
    ];
});
