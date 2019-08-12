<?php

$factory->define(App\Patient::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "gender" => collect(["1","2",])->random(),
        "age" => $faker->randomNumber(2),
        "oranization_id" => factory('App\Organization')->create(),
        "diagnostic" => $faker->name,
        "address" => $faker->name,
        "contact" => $faker->name,
        "description" => $faker->name,
    ];
});
