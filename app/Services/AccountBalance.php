<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\AccountBalance as Model_AccountBalance;
use Exception;
class AccountBalance
{
    public static function create($params)
    {
        $balance = new Model_AccountBalance();

        return $balance->create($params);
    }

    public static function update($params)
    {
        $balance = new Model_AccountBalance();

        $balance = $balance->account($params['account_id']);

        if ($balance) {
            return $balance->update($params);
        }

        return false;
    }

    /*
    * Adiciona um novo valor no free amount
    * @params['account_id']
    * @params['free_amount']
    */
    public static function addFreeAmount($params)
    {
        $balance = (new Model_AccountBalance)->account($params['account_id']);

        if ($balance
            && isset($params['free_amount'])
            && intval($params['free_amount']) > 0
        ) {
            $params['free_amount'] = ($params['free_amount'] + $balance->free_amount);
            return $balance->update($params);
        }

        return false;
    }

    /*
    * Subtrai valor do free amount
    * @params['account_id']
    * @params['free_amount']
    */
    public static function subFreeAmount($params)
    {
        $balance = (new Model_AccountBalance)->account($params['account_id']);

        if ($balance
            && isset($params['free_amount'])
            && intval($params['free_amount']) > 0
            && $balance->free_amount >= $params['free_amount']
        ) {
            $params['free_amount'] = ($balance->free_amount - $params['free_amount']);
            return $balance->update($params);
        } else {
            throw new Exception('Invalid amount or insufficient funds!');
        }

        return false;
    }

    public static function getBalance($account_id)
    {
        $account = (new Model_AccountBalance)->account($account_id);

        return $account;
    }

    /*
    * Adiciona um novo valor no blocked amount
    * @params['account_id']
    * @params['blocked_amount']
    */
    public static function addBlockedAmount($params)
    {
        $balance = (new Model_AccountBalance)->account($params['account_id']);

        if ($balance
            && isset($params['blocked_amount'])
            && intval($params['blocked_amount']) > 0
        ) {
            $params['blocked_amount'] = ($params['blocked_amount'] + $balance->blocked_amount);
            return $balance->update($params);
        }

        return false;
    }

    public static function unblockBalance(Account $account, $amount)
    {
        $balance = \App\Models\AccountBalance::where('account_id',$account->id)->first();

        $balance->free_amount = $balance->free_amount + $amount;
        $balance->blocked_amount = $balance->blocked_amount - $amount;
        $balance->save();

        return $balance;
    }
}
