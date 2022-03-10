<?php

namespace App\Observers;

use Illuminate\Support\Carbon;
use App\Models\Withdrawal;
use App\Services\Movimentation;
use App\Services\AccountBalance;
use Exception;

class WithdrawalObserver
{
    public function creating(Withdrawal $withdrawal)
    {
        $balance = (new AccountBalance)->getBalance($withdrawal->account_id);

        if ($withdrawal->amount > $balance->free_amount) {
            throw new Exception('Insufficient funds!');
        }

        if ($withdrawal->amount < 0) {
            throw new Exception('The value must be greater than 0!');
        }
    }

    public function updating(Withdrawal $withdrawal)
    {
        if ($withdrawal->isDirty('withdrawal_uuid')) {
            throw new Exception("Changing the UUID is not allowed!");
        }
    }

    public function deleting(Withdrawal $withdrawal)
    {
    }

    public function created(Withdrawal $withdrawal)
    {
        $newMovimentation = [
            'account_id' => $withdrawal->account_id,
            'amount' => $withdrawal->amount,
            'withdrawal_id' => $withdrawal->id,
            'type' => 'withdrawal',
        ];
        try {
            $balance = (new AccountBalance)->getBalance($withdrawal->account_id);
            if ($balance->free_amount >= $withdrawal->amount) {
                (new Movimentation)->create($newMovimentation);

                $newBalance = [
                    'account_id' => $withdrawal->account_id,
                    'free_amount' => $withdrawal->amount,
                ];

                return (new AccountBalance)->subFreeAmount($newBalance);
            } else {
                throw new Exception('Insufficient funds!');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updated(Withdrawal $withdrawal)
    {
    }
}
