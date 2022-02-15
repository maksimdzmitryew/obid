<?php

use Faker\Generator as Faker;
use Faker\Factory;

$a_langs = config('translatable.languages');
foreach ($a_langs AS $s_lang => $s_country)
{
    $a_faker[$s_lang] = Factory::create($s_lang . '_' . $s_country);
}

$factory->define(\Modules\Country\Database\Country::class, function (Faker $faker) use ($a_faker, $factory) {

    $a_data = [
        'published' => 1,
        'slug' => strtoupper(substr($faker->word(),0,2)),
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
