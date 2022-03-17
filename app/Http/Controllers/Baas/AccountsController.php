<?php

namespace App\Http\Controllers\Baas;

use App\Http\Controllers\Controller;
use App\Services\Baas\AccountService;

use Illuminate\Http\Request;


class AccountsController extends Controller
{

  public function sendNotification(Request $request)
  {
    $accountService = new AccountService();
    $response = $accountService->create($request->all());

    return response()->json($response, 201);
  }

  public function blockAccount(Request $request)
  {
    $accountService = new AccountService();
    $response = $accountService->blockAccount($request->all());

    return response()->json($response, 200);
  }

  public function blockAccountSpecialRefund(Request $request)
  {
    $accountService = new AccountService();
    $response = $accountService->blockAccountSpecialRefund($request->all());

    return response()->json($response, 200);
  }
  
  public function unblockAccount(Request $request)
  {
    $accountService = new AccountService();
    $response = $accountService->unblockAccount($request->all());

    return response()->json($response, 200);
  }

  public function accountBalance(Request $request, string $codIspb, string $codAgencia, string $nroConta, string $tipoConta, string $cpfCnpj)
  {
    $accountService = new AccountService();
    $response = $accountService->accountBalance($request->all(), $codIspb, $codAgencia, $nroConta, $tipoConta, $cpfCnpj);

    return response()->json($response, 200);
  }

  public function accountBalanceBlockSpecialRefund(Request $request, string $codIspb, string $codAgencia, string $nroConta, string $tipoConta, string $cpfCnpj, string $uuidBloqueioDevolucaoEspecial)
  {
    $accountService = new AccountService();
    $response = $accountService->accountBalanceBlockSpecialRefund($request->all(), $codIspb, $codAgencia, $nroConta, $tipoConta, $cpfCnpj, $uuidBloqueioDevolucaoEspecial);

    return response()->json($response, 200);
  }

  public function accountTransaction(Request $request)
  {
    $accountService = new AccountService();
    $response = $accountService->accountTransaction($request->all());

    return response()->json($response, 200);
  }

  public function accountReceiverValidator(Request $request)
  {
    $accountService = new AccountService();
    $response = $accountService->accountReceiverValidator($request->all());

    return response()->json($response, 200);
  }
}
