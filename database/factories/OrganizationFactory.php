<?php

$factory->define(App\Organization::class, function (Faker\Generator $faker) {
    return [
        "name_kh" => $faker->name,
        "name_en" => $faker->name,
        "address" => $faker->name,
        "contact" => $faker->name,
        "description" => $faker->name,
        "active" => 1,
    ];
});
