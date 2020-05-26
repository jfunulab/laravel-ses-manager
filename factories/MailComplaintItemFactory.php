<?php


/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Megaverse\LaravelSesManager\Eloquent\MailComplaint;
use Megaverse\LaravelSesManager\Eloquent\MailComplaintGroup;

$factory->define(MailComplaint::class, function (Faker $faker) {
    return [
        'group_id' => function(){
            return factory(MailComplaintGroup::class)->create()->id;
        },
        'email' => $faker->email,
    ];
});