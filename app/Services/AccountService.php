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


    public function getList(string $orderBy = 'id', string $sortBy = 'ASC', int $limit = 10) : array
    {
	$accountList = AccountRepository::list($orderBy, $sortBy, $limit);
	
	return $accountList;
    }
}
