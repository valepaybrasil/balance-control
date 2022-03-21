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


    public static function list(string $orderBy = 'free_amount', string $sortBy = 'ASC', int $limit = 10) : array
    {
	    $accountList = [];

	$query = "SELECT
			a.id AS a_id,
			ab.id AS ab_id,
			ab.free_amount AS ab_free_amount

		FROM accounts AS a 
		INNER JOIN account_balances AS ab ON ab.account_id = a.id
		WHERE
			a.deleted_at IS NULL
			AND ab.deleted_at IS NULL
		ORDER BY {$orderBy} {$sortBy}
	;";

	    $accountsFetch = DB::select($query);
	
	    foreach ($accountsFetch as $accountFetch) {

		    $account = [
			    'id' => $accountFetch->a_id,
		    ];

		    $accountBalance = [
			    'id' => $accountFetch->ab_id,
				'free_amount' => $accountFetch->ab_free_amount
		    ];
	
		
		    $accountList[] = [
			    'account' => $account,
			    'account_balance' => $accountBalance
		    ];
	    }

	    return $accountList;
	}
}
