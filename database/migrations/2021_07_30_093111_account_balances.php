<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountBalances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_balances', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('account_id')->unsigned();
            $table->decimal('free_amount', 12, 2)->default(0.00);
            $table->decimal('blocked_amount', 12, 2)->default(0.00);
            $table->decimal('debit_amount', 12, 2)->default(0.00);
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_balances');
    }
}
