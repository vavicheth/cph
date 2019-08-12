<?php

$factory->define(App\Medicine::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "type" => $faker->name,
        "price" => $faker->randomNumber(2),
        "extend_price" => $faker->randomNumber(2),
        "expire_date" => $faker->date("d-m-Y", $max = 'now'),
        "company" => $faker->name,
        "manual" => 0,
        "description" => $faker->name,
        "active" => 1,
    ];
});
