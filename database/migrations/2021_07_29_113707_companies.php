<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Companies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->uuid('company_uuid')->unique();
            $table->string('name');
            $table->string('fantasy_name');
            $table->string('document');
            $table->string('external_uuid')->nullable();
            $table->string('email')->nullable();
            $table->integer('person_id')->unsigned()->nullable();;
            $table->foreign('person_id')->references('id')->on('persons');
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
        Schema::dropIfExists('companies');
    }
}
