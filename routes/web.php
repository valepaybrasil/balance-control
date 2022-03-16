<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "API Conta Digital";
});

$router->post('login','LoginController@login');


$router->group(['middleware' => ['auth:api'], 'prefix' => 'accounts'], function () use ($router) {
    //Accounts balance routes
    $router->get('/balance/', 'AccountBalanceController@index');
    $router->get('/balance/{uuid}', 'AccountBalanceController@show');
    $router->put('/balance/addblockedamount', 'AccountBalanceController@addBlockedAmount');
    $router->put('/balance/adddebitamount', 'AccountBalanceController@addDebitAmount');
    $router->post('/balance/debitFreeAmount', 'AccountBalanceController@debitFreeAmount');
    $router->get('all/balance', 'AccountBalanceController@allAccountsBalance');



    //Accounts routes
    $router->get('/', 'AccountController@index');
    $router->get('/{uuid}', 'AccountController@show');
    $router->post('/', 'AccountController@store');
    $router->post('company', 'AccountController@storeCompany');
    $router->put('/{uuid}', 'AccountController@update');
    $router->put('/block/{uuid}', 'AccountController@block');
    $router->put('/unblock/{uuid}', 'AccountController@unblock');
    $router->delete('/{account}', 'AccountController@destroy');
});


$router->group(['middleware' => ['auth:api'], 'prefix' => 'account'], function () use ($router) {
    $router->post('/', 'AccountController@storeCompany');
});

$router->group(['middleware' => ['auth:api'], 'prefix' => 'persons'], function () use ($router) {
    $router->get('/', 'PersonController@index');
    $router->get('/{uuid}', 'PersonController@show');
    $router->post('/', 'PersonController@store');
    $router->put('/{uuid}', 'PersonController@update');
    $router->delete('/{uuid}', 'PersonController@destroy');
});

$router->group(['middleware' => ['auth:api'], 'prefix' => 'deposits'], function () use ($router) {
    $router->get('/', 'DepositController@index');
    $router->get('/{uuid}', 'DepositController@show');
    $router->post('/', 'DepositController@store');
    $router->put('/{uuid}', 'DepositController@update');
});

$router->group(['middleware' => ['auth:api'], 'prefix' => 'transfers'], function () use ($router) {
    $router->get('/', 'TransferController@index');
    $router->get('/{uuid}', 'TransferController@show');
    $router->post('/', 'TransferController@store');
    $router->put('/{uuid}', 'TransferController@update');
});

$router->group(['middleware' => ['auth:api'], 'prefix' => 'withdrawals'], function () use ($router) {
    $router->get('/', 'WithdrawalController@index');
    $router->get('/{uuid}', 'WithdrawalController@show');
    $router->post('/', 'WithdrawalController@store');
});


$router->group(['middleware' => ['auth:api'], 'prefix' => 'balance'], function () use ($router) {
    $router->post('/unblock', 'DepositController@unblock');
});


$router->group(['middleware' => [], 'prefix' => 'webhook'], function () use ($router) {
    
    $router->group(['prefix' => 'arch'], function () use ($router) {
        $router->get('logger', 'Baas\LoggerController@getLogger');
        $router->get('logger/{logger}', 'Baas\LoggerController@getLoggerDetail');
        $router->post('logger', 'Baas\LoggerController@create');
    });
});

