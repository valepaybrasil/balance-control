<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Person;
use App\Models\Transfer;

class TransferController extends Controller
{
    private $transfer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function index(Request $request)
    {
        return $this->transfer->paginate(50);
    }

    public function show($uuid)
    {
        return $this->transfer->uuid($uuid);
    }

    public function store(Request $request)
    {
        $request['transfer_uuid'] = (string) Str::uuid();

        $originAccount = (new Account)->uuid($request['account_origin_uuid']);

        if (!$originAccount) {
            return response()->json(['error' => 'Invalid origin account!'], 401);
        }

        $request['account_origin_id'] = $originAccount->id;

        $destinationAccount = (new Account)->uuid($request['account_destination_uuid']);

        if (!$destinationAccount) {
            return response()->json(['error' => 'Invalid destination account!'], 401);
        }
        $request['account_destination_id'] = $destinationAccount->id;

        $this->validate($request, $this->transfer->rules);

        return $this->transfer->create($request->all());
    }

    public function update($uuid, Request $request)
    {
        try {
            $transfer = $this->transfer->uuid($uuid);
            if ($transfer) {
                $transfer->update($request->all());
                return response()->json(['transfer' => $transfer]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['error' => 'Transfer not found!'], 401);
    }
}
