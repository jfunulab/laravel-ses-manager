<?php


/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Jfunu\LaravelSesManager\Eloquent\MailComplaint;
use Jfunu\LaravelSesManager\Eloquent\MailComplaintGroup;

$factory->define(MailComplaint::class, function (Faker $faker) {
    return [
        'group_id' => function(){
            return factory(MailComplaintGroup::class)->create()->id;
        },
        'email' => $faker->email,
    ];
});