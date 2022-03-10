<?php

namespace Database\Seeders;

use App\Models\AccountBalance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        

        DB::table('account_balances')->insert([

            [
                'account_id' => 1,
                'free_amount' =>  0.0,
                'blocked_amount' =>  0.0,
                'debit_amount' => 0.0,
            ],
            [
                'account_id' => 2,
                'free_amount' =>  0.0,
                'blocked_amount' =>  0.0,
                'debit_amount' => 0.0,
            ],
            [
                'account_id' => 3,
                'free_amount' =>  0.0,
                'blocked_amount' =>  0.0,
                'debit_amount' => 0.0,
            ]


        ]);
    }
}
