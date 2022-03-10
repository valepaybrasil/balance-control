<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\AccountBalance;
use App\Services\Movimentation;
use Exception;

class AccountBalanceController extends Controller
{
    private $account_balance;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AccountBalance $account_balance)
    {
        $this->account_balance = $account_balance;
    }

    public function index(Request $request)
    {
        return $this->account_balance->paginate(50);
    }

    public function show($uuid)
    {
        $account = (new Account)->uuid($uuid);

        if ($account) {
            return $this->account_balance->account($account->id);
        } else {
            return response()->json(['error' => 'Invalid account!'], 401);
        }
    }

    public function store(Request $request)
    {
        $account = (new Account)->uuid($request['account_uuid']);

        if ($account) {
            $request['account_id'] = $account->id;
        } else {
            return response()->json(['error' => 'Invalid account!'], 401);
        }

        $this->validate($request, $this->account_balance->rules);

        return $this->account_balance->create($request->all());
    }

    public function addBlockedAmount(Request $request)
    {
        try {
            $account = (new Account)->uuid($request['account_uuid']);
            if(empty($request['blocked_amount']) || intval($request['blocked_amount']) <= 0) {
                return response()->json(['error' => 'Invalid blocked amount!'], 401);
            }

            if ($account) {
                $account_balance = $this->account_balance->account($account->id);
                if ($account_balance) {
                    $blocked_amount = $account_balance->blocked_amount + $request['blocked_amount'];

                    $newMovimentation = [
                        'account_id' => $account->id,
                        'amount' => $request['blocked_amount'],
                        'type' => 'block',
                    ];

                    (new Movimentation)->create($newMovimentation);

                    $account_balance->update(['blocked_amount' => $blocked_amount]);
                    return response()->json(['account_balance' => $account_balance]);
                }
            } else {
                return response()->json(['error' => 'Invalid account!'], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['error' => 'AccountBalance not found!'], 401);
    }

    public function addDebitAmount(Request $request)
    {
        try {
            $account = (new Account)->uuid($request['account_uuid']);
            if(empty($request['debit_amount']) || intval($request['debit_amount']) <= 0) {


                return response()->json(['error' => 'Invalid debit amount!'], 401);
            }

            if ($account) {
                $account_balance = $this->account_balance->account($account->id);
                if ($account_balance) {
                    $debit_amount = $request['debit_amount'] + $account_balance->debit_amount;

                    $newMovimentation = [
                        'account_id' => $account->id,
                        'amount' => $request['debit_amount'],
                        'type' => 'debit',
                    ];

                    (new Movimentation)->create($newMovimentation);

                    $account_balance->update(['debit_amount' => $debit_amount]);
                    return response()->json(['account_balance' => $account_balance]);
                }
            } else {
                return response()->json(['error' => 'Invalid account!'], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['error' => 'AccountBalance not found!'], 401);
    }


    public function debitFreeAmount(Request $request)
    {
        try {
            $account = (new Account)->uuid($request['account_uuid']);
            if(empty($request->input('debit_amount'))) {

                return response()->json(['error' => 'Invalid debit amount!'], 401);
            }

            if ($account) {
                $account_balance = $this->account_balance->account($account->id);
                if ($account_balance) {
                    $debit_amount = $account_balance->free_amount - $request->input('debit_amount') ;

                    $newMovimentation = [
                        'account_id' => $account->id,
                        'amount' => $request->input('debit_amount'),
                        'type' => 'debit',
                    ];

                    (new Movimentation)->create($newMovimentation);

                    $account_balance->update(['free_amount' => $debit_amount]);
                    return response()->json(['account_balance' => $account_balance]);
                }
            } else {
                return response()->json(['error' => 'Invalid account!'], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['error' => 'AccountBalance not found!'], 401);
    }

    public function allAccountsBalance()
    {
        try {

            $account_balances = AccountService::allAccountBalances();

            return response()->json(['total_balances' => $account_balances]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['error' => 'AccountBalance not found!'], 401);
    }
}
