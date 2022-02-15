<?php

use Faker\Generator as Faker;
use Faker\Factory;

$a_langs = config('translatable.languages');
foreach ($a_langs AS $s_lang => $s_city)
{
    $a_faker[$s_lang] = Factory::create($s_lang . '_' . $s_city);
}

$factory->define(\Modules\City\Database\City::class, function (Faker $faker) use ($a_faker, $factory) {

    $a_data = [
        'country_id' => function() {
            return factory(\Modules\Country\Database\Country::class)->create()->id;
        },
        'timezone' => collect(timezone_identifiers_list())->random(),
        'published' => 1,
    ];

    foreach ($a_faker AS $s_lang => $o_faker)
    {
        $a_data[$s_lang] =
        [
            'title' => $o_faker->word,
        ];
    }
    return $a_data;
});
