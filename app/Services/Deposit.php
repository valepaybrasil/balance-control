<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Deposit as Model_Deposit;

class Deposit
{
    public static function create(Request $request)
    {
        $deposit = new Model_Deposit();

        return $deposit->create($request);
    }



}
