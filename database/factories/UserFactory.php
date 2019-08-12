<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        "name_kh" => $faker->name,
        "name" => $faker->name,
        "email" => $faker->safeEmail,
        "password" => str_random(10),
        "role_id" => factory('App\Role')->create(),
        "remember_token" => $faker->name,
    ];
});
