<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bank;
use App\Models\CardOrLoan;
use App\User;
use Faker\Generator as Faker;

$factory->define(CardOrLoan::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'bank_id' => Bank::all()->random()->id,
        'office_name' => $faker->company,
        'office_address' => $faker->address,
        'designation' => $faker->sentence,
        'basic_salary' => $faker->numberBetween(12000,36548),
        'gross_salary' => $faker->numberBetween(12000,36548),
        'salary_payment_by_bank' => $faker->name,
        'cash_payment_by_bank' => $faker->name,
        'a_t' => $faker->countryISOAlpha3,
        'loan_limit_amount' => $faker->numberBetween(1000,20000),
        'secondary_bank_loan' => 'yes',
        'secondary_bank_name' => $faker->word(),
        'secondary_bank_amount' => $faker->numberBetween(1000,50000),
        'secondary_bank_address' => $faker->address,
        'salary_certificate' => $faker->imageUrl(),
        'tin_certificate' => $faker->imageUrl(),
        'nid_card_front' => $faker->imageUrl(),
        'nid_card_back' => $faker->imageUrl(),
        'job_id_card' => $faker->imageUrl(),
        'visiting_card' => $faker->imageUrl(),
        'apply_for' => 'loan',
        'status' => rand(1,0),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
