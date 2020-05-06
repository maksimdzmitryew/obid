<?php

use Faker\Generator as Faker;

$factory->define(App\EventHolding::class, function (Faker $faker) {
    $numberOfWeeks = rand(1, 52);

    return [
        'event_id' => function() {
            return factory(App\Event::class)->create()->id;
        },
        'date_from' => now()->addWeeks($numberOfWeeks),
        'date_to' => now()->addWeeks($numberOfWeeks)->addHour(1)->addMinutes(30),
        'place_id' => function() {
            return factory(App\Place::class)->create()->id;
        },
        'ticket_url' => $faker->url
    ];
});
