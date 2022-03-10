<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->uuid('transfer_uuid')->unique();
            $table->integer('account_origin_id')->unsigned();
            $table->integer('account_destination_id')->unsigned();
            $table->decimal('amount', 12, 2);
            $table->dateTime('date');
            $table->foreign('account_origin_id')->references('id')->on('accounts');
            $table->foreign('account_destination_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('transfers');
    }
}
