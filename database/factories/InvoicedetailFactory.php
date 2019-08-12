<?php

$factory->define(App\Invoicedetail::class, function (Faker\Generator $faker) {
    return [
        "invoice_id" => factory('App\Invoice')->create(),
        "medicine_id" => factory('App\Medicine')->create(),
        "type" => $faker->name,
        "qty" => $faker->randomNumber(2),
        "unit_price" => $faker->randomNumber(2),
        "total" => $faker->randomNumber(2),
    ];
});
