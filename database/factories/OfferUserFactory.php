<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\OfferUser;
use Faker\Generator as Faker;

$factory->define(OfferUser::class, function (Faker $faker) {
    return [
        'offer_id' => factory(\App\Offer::class)->create()->id,
        'user_id' => factory(\App\User::class)->create()->id,
        'code'  => $faker->text(8),
        'activate' => false
    ];
});
