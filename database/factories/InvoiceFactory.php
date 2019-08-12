<?php

$factory->define(App\Invoice::class, function (Faker\Generator $faker) {
    return [
        "date" => $faker->date("d-m-Y", $max = 'now'),
        "patient_id" => factory('App\Patient')->create(),
        "invstate_id" => $faker->randomNumber(2),
        "total" => $faker->randomNumber(2),
        "description" => $faker->name,
    ];
});
