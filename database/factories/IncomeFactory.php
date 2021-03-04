<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Income;
use Faker\Generator as Faker;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'balance' => $faker->randomFloat(3, 0, 100.999),
        'title' => $faker->word(),
        'description' => $faker->text
    ];
});
