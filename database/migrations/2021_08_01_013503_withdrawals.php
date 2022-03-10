<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Withdrawals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->uuid('withdrawal_uuid')->unique();
            $table->integer('account_id')->unsigned();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['billit', 'debit', 'rate','withdrawal']);
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
        Schema::dropIfExists('withdrawals');
    }
}
