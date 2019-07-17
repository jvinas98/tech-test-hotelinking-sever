<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Offer;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(0, 100),
    ];
});
