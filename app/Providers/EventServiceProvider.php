<?php

namespace App\Providers;

use App\Listeners\RevokeOtherTokens;
use App\Listeners\PruneRevokedTokens;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\Transfer;
use App\Models\Withdrawal;
use App\Observers\AccountObserver;
use App\Observers\DepositObserver;
use App\Observers\TransferObserver;
use App\Observers\WithdrawalObserver;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Laravel\Passport\Events\AccessTokenCreated' => [
            RevokeOtherTokens::class,
            PruneRevokedTokens::class,
        ],
    ];


    public function boot()
    {
        Account::observe(AccountObserver::class);
        Deposit::observe(DepositObserver::class);
        Transfer::observe(TransferObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
    }
}
