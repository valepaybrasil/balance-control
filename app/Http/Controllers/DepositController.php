<?php

namespace App\Http\Controllers;

use App\Services\AccountBalance;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Person;
use App\Models\Deposit;
use Exception;

class DepositController extends Controller
{
    private $deposit;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
    }

    public function index(Request $request)
    {
        return $this->deposit->paginate(50);
    }

    public function show($uuid)
    {
        return $this->deposit->uuid($uuid);
    }

    public function store(Request $request)
    {
        $request['deposit_uuid'] = (string) Str::uuid();
        $account = (new Account)->uuid($request['account_uuid']);

        if ($account) {
            $request['account_id'] = $account->id;
        } else {
            return response()->json(['error' => 'Invalid account!'], 401);
        }

        $this->validate($request, $this->deposit->rules);

        return $this->deposit->create($request->all());
    }


    public function unblock(Request $request)
    {
        $account =  AccountService::getAccount($request->input('account_uuid'));

        if (! $account)   return response()->json(['error' => 'Invalid account!'], 401);

        //TODO Validar esse request
        //$this->validate($request, $this->deposit->rules);

        return AccountBalance::unblockBalance($account, $request->input('amount'));
    }

    public function update($uuid, Request $request)
    {
        try {
            $deposit = $this->deposit->uuid($uuid);
            if ($deposit) {
                $deposit->update($request->all());
                return response()->json(['deposit' => $deposit]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['error' => 'Deposit not found!'], 401);
    }
}
