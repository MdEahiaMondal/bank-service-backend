<?php

use App\Models\Bank;
use App\Models\Card;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(User::class, 20)->create();
        factory(Bank::class, 50)->create();
        factory(Card::class, 20)->create();
    }
}
