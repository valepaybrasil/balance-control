<?php

namespace App\Observers;

use Illuminate\Support\Carbon;
use App\Models\Deposit;
use App\Services\Movimentation;
use App\Services\AccountBalance;
use Exception;

class DepositObserver
{
    public function creating(Deposit $deposit)
    {
        if ($deposit->amount <= 0) {
            throw new Exception('The value must be greater than 0!');
        }
    }

    public function updating(Deposit $deposit)
    {

        if ($deposit->isDirty('deposit_uuid')) {
            throw new Exception("Changing the UUID is not allowed!");
        }
    }

    public function deleting(Deposit $deposit)
    {
    }

    public function created(Deposit $deposit)
    {
        $newMovimentation = [
            'account_id' => $deposit->account_id,
            'deposit_id' => $deposit->id,
            'amount' => $deposit->amount,
            'type' => 'deposit',
        ];
        try {
            (new Movimentation)->create($newMovimentation);
            if ($deposit->transfer_date <= Carbon::now()->toDateString()) {
                $newBalance = [
                    'account_id' => $deposit->account_id,
                    'free_amount' => $deposit->amount,
                ];

                (new AccountBalance)->addFreeAmount($newBalance);

                (new Deposit)->findOrFail($deposit->id)->update([
                    'is_settled' => 1,
                    'settled_date' => Carbon::now()->toDateString(),
                ]);
            } else {
                $newBalance = [
                    'account_id' => $deposit->account_id,
                    'blocked_amount' => $deposit->amount,
                ];

                (new AccountBalance)->addBlockedAmount($newBalance);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updated(Deposit $deposit)
    {
    }
}
