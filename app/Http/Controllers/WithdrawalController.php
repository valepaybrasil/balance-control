<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Person;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    private $withdrawal;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function index(Request $request)
    {
        return $this->withdrawal->paginate(50);
    }

    public function show($uuid)
    {
        return $this->withdrawal->uuid($uuid);
    }

    public function store(Request $request)
    {
        $request['withdrawal_uuid'] = (string) Str::uuid();

        if (!in_array($request['type'], ['billit', 'debit', 'rate','withdrawal'])) {
            return response()->json(['error' => 'Invalid withdrawal type!'], 401);
        }

        $account = (new Account)->uuid($request['account_uuid']);

        if (!$account) {
            return response()->json(['error' => 'Invalid account!'], 401);
        }

        $request['account_id'] = $account->id;

        $this->validate($request, $this->withdrawal->rules);

        return $this->withdrawal->create($request->all());
    }

    public function update($uuid, Request $request)
    {
        $withdrawal = $this->withdrawal->uuid($uuid);

        return $withdrawal->update($request->all());
    }
}
