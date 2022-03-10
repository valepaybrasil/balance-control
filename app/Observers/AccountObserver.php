<?php

namespace App\Observers;

use App\Models\Account;
use App\Services\AccountBalance;
use Exception;

class AccountObserver
{
    public function creating(Account $account)
    {
    }

    public function updating(Account $account)
    {
        if ($account->isDirty('account_uuid')) {
            throw new Exception("Changing the UUID is not allowed!");
        }
    }

    public function deleting(Account $account)
    {
    }

    public function created(Account $account)
    {
        if ($account) {
            $newBalance = [
                'account_id' => $account->id
            ];

            (new AccountBalance)->create($newBalance);
        }
    }

    public function updated(Account $account)
    {
    }
}
