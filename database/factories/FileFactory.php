<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
    $today = today();
    $relative_path = $today->year . '/' . $today->month . '/';
    $full_folder_path = storage_path() . '/app/public/' . $relative_path;

    return [
        'fileable_id' => null,
        'fileable_type' => null,
        'name' => $image_name = collect(explode('/', $faker->image($full_folder_path, 640, 480)))->last(),
        'type' => 'image',
        'url' => '/storage/' . $relative_path . $image_name,
        'path' => '/public/' . $relative_path . $image_name,
        'alt' => '',
        'role' => 'preview',
        'size' => round(filesize($full_folder_path . $image_name) / 1024, 0),
    ];
});
