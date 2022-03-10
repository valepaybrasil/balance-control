<?php

namespace Database\Seeders;

use App\Services\AccountService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PersonSeeder::class,
            CompaniesSeeder::class,
            UserSeeder::class,
            AccountsSeeder::class,
            AccountBalanceSeeder::class
        ]);
    }
}
