<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Movimentations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentations', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('account_id')->unsigned();
            $table->integer('transfer_id')->unsigned()->nullable();
            $table->integer('withdrawal_id')->unsigned()->nullable();
            $table->integer('deposit_id')->unsigned()->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['transfer', 'withdrawal', 'deposit', 'debit', 'block']);
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->foreign('withdrawal_id')->references('id')->on('withdrawals');
            $table->foreign('deposit_id')->references('id')->on('deposits');
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
        Schema::dropIfExists('movimentations');
    }
}
