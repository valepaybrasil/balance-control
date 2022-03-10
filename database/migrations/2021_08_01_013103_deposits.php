<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Deposits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->uuid('deposit_uuid')->unique();
            $table->integer('account_id')->unsigned();
            $table->decimal('amount', 12, 2);
            $table->boolean('is_settled')->default(0);
            $table->dateTime('transfer_date');
            $table->timestamp('settled_date')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
