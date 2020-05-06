<?php

use Faker\Generator as Faker;
use Faker\Factory;

$fakerCH = Factory::create('de_CH');

$factory->define(App\Artist::class, function (Faker $faker) use ($fakerCH) {
    return [
        'url' => $faker->url,
        'email' => $faker->safeEmail,
        'facebook' => $faker->url,
        #'team_member' => 0,
        #'board_member' => 0,
        'en' => [
            'profession' => $faker->word,
            'description' => $faker->sentence,
            'name' => $faker->name,
        ],
        'de' => [
            'profession' => $fakerCH->word,
            'description' => $fakerCH->sentence,
            'name' => $fakerCH->name,
        ]
    ];
});
