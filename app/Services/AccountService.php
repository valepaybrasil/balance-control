<?php

namespace App\Services;

use App\Models\Account;
use App\Repository\AccountRepository;

class AccountService
{
    public static function getAccount($uuid)
    {
        return Account::where('account_uuid', $uuid)->first();
    }


    public static function allAccountBalances()
    {
        $account_balances = AccountRepository::allAccountBalances();

        if (count($account_balances) > 0) return $account_balances[0];

        return $account_balances;


    }


}
