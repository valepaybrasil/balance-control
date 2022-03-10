<?php

namespace App\Observers;

use Illuminate\Support\Carbon;
use App\Models\Transfer;
use App\Services\Movimentation;
use App\Services\AccountBalance;
use Exception;

class TransferObserver
{
    public function creating(Transfer $transfer)
    {
        $freeBalance = (new AccountBalance)->getBalance($transfer->account_origin_id);
        if ($transfer->amount > $freeBalance->free_amount) {
            throw new Exception('Insufficient funds!');
        }

        if ($transfer->amount < 0) {
            throw new Exception('The value must be greater than 0!');
        }
    }

    public function updating(Transfer $transfer)
    {
        if ($transfer->isDirty('transfer_uuid')) {
            throw new Exception("Changing the UUID is not allowed!");
        }
    }

    public function deleting(Transfer $transfer)
    {
    }

    public function created(Transfer $transfer)
    {
        try {
            $newMovimentation = [
                'account_id' => $transfer->account_origin_id,
                'transfer_id' => $transfer->id,
                'amount' => $transfer->amount,
                'type' => 'transfer',
            ];

            (new Movimentation)->create($newMovimentation);

            //Verifica se tem saldo disponivel
            $balance = (new AccountBalance)->getBalance($transfer->account_origin_id, );
            if ($balance->free_amount >= $transfer->amount) {
                $debitBalance = [
                    'account_id' => $transfer->account_origin_id,
                    'free_amount' => $transfer->amount,
                ];
                (new AccountBalance)->subFreeAmount($debitBalance);

                $creditBalance = [
                    'account_id' => $transfer->account_destination_id,
                    'free_amount' => $transfer->amount,
                ];
                (new AccountBalance)->addFreeAmount($creditBalance);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updated(Transfer $transfer)
    {
    }
}
