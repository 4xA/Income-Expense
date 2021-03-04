<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'balance' => $faker->randomFloat(3, 0, 9999999.999),
        'title' => $faker->word(),
        'description' => $faker->text
    ];
});
