<?php

use Faker\Generator as Faker;
use Faker\Factory;

$a_langs = config('translatable.languages');
foreach ($a_langs AS $s_lang => $s_city)
{
    $a_faker[$s_lang] = Factory::create($s_lang . '_' . $s_city);
}

$factory->define(\Modules\Page\Database\Page::class, function (Faker $faker) use ($a_faker, $factory) {

    $a_data = [
        'published' => rand(0, 1),
        'slug' => $faker->unique()->slug,
    ];

    $b_parent = rand(0, 1);
    if ($b_parent)
    {
        $a_data[$s_lang] =
        [
            'page_id' => function() {
                return factory(\Modules\Page\Database\Page::class)->create()->id;
            },
        ];
    }

    foreach ($a_faker AS $s_lang => $o_faker)
    {
        $a_data[$s_lang] =
        [
            'slug' => $faker->unique()->slug,
            'title' => $faker->sentence,
            'excerpt' => $faker->paragraph,
            'body' => $faker->paragraphs(3, true),
            'meta_title' => $faker->word,
            'meta_description' => $faker->sentence,
            'meta_keywords' => $faker->word,
        ];
    }
    return $a_data;
});
