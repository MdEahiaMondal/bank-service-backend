<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bank;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Bank::class, function (Faker $faker) {
    $name = $faker->unique()->company;
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'image' => $faker->imageUrl(200,200),
        'location' => $faker->address,
        'status' => rand(1,0),
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id,
    ];
});
