<?php

use Faker\Generator as Faker;
use Faker\Factory;

$a_faker['en'] = Factory::create('en_US');
$a_faker['uk'] = Factory::create('uk_UA');

$factory->define(App\User::class, function (Faker $faker) use ($a_faker) {

    $s_password = str_random(rand(6,10));

    return [
#        'role_id' => function() {
#            return factory(App\Role::class)->create()->id;
#        },
        'first_name' => $a_faker['uk']->firstName,
        'last_name'  => $a_faker['uk']->lastName,
        'email' => $a_faker['uk']->unique()->safeEmail,
        'enabled' => true,
        'password' => bcrypt($s_password),
        'remember_token' => str_random(10), # this might need an extra "use" as of laravel 6+ version (see upgrade guide)
    ];
});
