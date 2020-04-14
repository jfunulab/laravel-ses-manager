<?php


/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Jfunu\LaravelSesManager\Eloquent\MailComplaintGroup;

$factory->define(MailComplaintGroup::class, function (Faker $faker) {
    return [
        'driver' => $faker->word,
        'reason' => $faker->sentence,
        'complained_at' => $faker->dateTime,
        'payload' => $faker->sentence,
    ];
});