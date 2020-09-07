<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bank;
use App\Models\Card;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Card::class, function (Faker $faker) {
    $name = $faker->unique()->name;
    return [
        'bank_id' => Bank::all()->random()->id,
        'name' => $name,
        'slug' => Str::slug($name),
        'status' => rand(1,0),
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id,
    ];});
