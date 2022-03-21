<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    /**
     * list accounts by bigger balance
     *
     * @return void
     */
    public function testListAccountsSortedByBalance()
    {
	$user = \App\Models\User::first();
        $this->actingAs($user, 'api');


	$totalRecords = 10;

	$this->get("/accounts/list?order_by=free_amount&sort_by=DESC&limit={$totalRecords}");

	$accountsList = json_decode($this->response->getContent())->data;

	$this->assertTrue(
		$accountsList[0]->account_balance->free_amount >= $accountsList[count($accountsList) -1]->account_balance->free_amount
            #$this->app->version(), $this->response->getContent()
        );
    }
}
