<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Accounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->uuid('account_uuid')->unique();
            $table->integer('person_id')->unsigned()->nullable();;
            $table->integer('company_id')->unsigned()->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamp('blocked_at')->nullable();
            $table->string('account_name')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
