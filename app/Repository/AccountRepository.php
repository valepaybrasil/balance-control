<?php

namespace App\Repository;

use App\Models\Account;
use App\Models\AccountBalance;
use Illuminate\Support\Facades\DB;

class AccountRepository
{


    public static function allAccountBalances()
    {
        $query = "select sum(free_amount) as total_free_amount, sum(blocked_amount) as total_blocked_amount, sum(debit_amount) as total_debit_amount
                    FROM account_balances;";

        $accounts_balance = DB::select($query);


        return $accounts_balance;


    }


}
