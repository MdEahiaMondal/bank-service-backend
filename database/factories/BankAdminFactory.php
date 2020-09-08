<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bank;
use App\Models\BankAdmin;
use App\User;
use Faker\Generator as Faker;

$factory->define(BankAdmin::class, function (Faker $faker) {
    $name = $faker->unique()->company;
    return [
        'user_id' => User::all()->random()->id,
        'bank_id' => Bank::all()->random()->id,
        'designation' => $faker->sentence,
        'per_user_benefit' => 50,
        'status' => rand(1,0),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
