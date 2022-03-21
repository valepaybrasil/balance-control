<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Services\AccountService;


class AccountServiceTest extends TestCase
{
    /**
     * list accounts by bigger balance
     *
     * @return void
     */
    public function testListAccountsSortedByBalance()
    {
	$orderedBy = 'free_amount';
	$sortedBy = 'DESC';
	$limit = 10;

	$accountService = new AccountService();
	$accountsList = $accountService->getList($orderedBy, $sortedBy, $limit);

	$this->assertTrue(
		$accountsList[0]['account_balance']['free_amount'] > $accountsList[count($accountsList) -1]['account_balance']['free_amount']
        );
    }
}
