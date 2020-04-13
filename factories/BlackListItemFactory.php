<?php


/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Jfunu\LaravelSesManager\Eloquent\BlackListGroup;
use Jfunu\LaravelSesManager\Eloquent\BlackListItem;

$factory->define(BlackListItem::class, function (Faker $faker) {
    return [
        'group_id' => function(){
            return factory(BlackListGroup::class)->create()->id;
        },
        'email' => $faker->email,
        'blacklisted_at' => $faker->dateTime,
    ];
});