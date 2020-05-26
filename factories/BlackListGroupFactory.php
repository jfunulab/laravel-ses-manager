<?php


/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Megaverse\LaravelSesManager\Eloquent\BlackListGroup;

$factory->define(BlackListGroup::class, function (Faker $faker) {
    return [
        'driver' => $faker->word,
        'reason' => $faker->sentence,
        'bounced_at' => $faker->dateTime,
        'payload' => $faker->sentence,
    ];
});