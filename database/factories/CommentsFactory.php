<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->realText(),
        'created_at' => $faker->dateTimeBetween('-3 days'),
        'updated_at' => $faker->dateTimeBetween('-1 days')
    ];
});
