<?php

namespace App\Services\Baas;


use App\Traits\RequestService;


class AccountService
{
  use RequestService;

  public $baseUri;
  public $secret;


  public function __construct()
  {
    $this->baseUri = config('microservices.baas.base_uri');
    $this->secret = config('microservices.baas.secret');
  }


  public function create(array $data)
  {
    return $this->request('POST', '/gi/push/enviar_notificacao', $data);
  }

  public function blockAccount(array $data)
  {
    $responseData = $this->request('POST', '/gi/eb/conta/bloqueio', $data);

    return [
      'chaveBloqueio' => $responseData->data->chaveBloqueio,
      'codErro' => $responseData->data->codErro,
      'mensagemErro' => $responseData->data->mensagemErro,
      'status' => $responseData->data->status,
    ];
  }

  public function blockAccountSpecialRefund(array $data)
  {
    $responseData = $this->request('POST', '/gi/eb/conta/bloqueio_devolucao_especial', $data);

    return [
      'chaveBloqueio' => $responseData->data->chaveBloqueio,
      'codErro' => $responseData->data->codErro,
      'mensagemErro' => $responseData->data->mensagemErro,
      'status' => $responseData->data->status,
    ];
  }

  public function unblockAccount(array $data)
  {
    $responseData = $this->request('POST', '/gi/eb/conta/desbloqueio', $data);

    return [
      'chaveBloqueio' => $responseData->data->chaveBloqueio,
      'codErro' => $responseData->data->codErro,
      'mensagemErro' => $responseData->data->mensagemErro,
      'status' => $responseData->data->status,
    ];
  }

  public function accountBalance(array $data, string $codIspb, string $codAgencia, string $nroConta, string $tipoConta, string $cpfCnpj)
  {
    $responseData = $this->request('GET', "/gi/eb/conta/saldo_conta/{$codIspb}/{$codAgencia}/{$nroConta}/{$tipoConta}/{$cpfCnpj}", $data);

    return [
      'saldoBloq' => $responseData->data->saldoBloq,
      'nroErro' => $responseData->data->nroErro,
      'saldoDisp' => $responseData->data->saldoDisp,
      'saldoTotal' => $responseData->data->saldoTotal,
      'mensagemErro' => $responseData->data->mensagemErro,
    ];
  }

  public function accountBalanceBlockSpecialRefund(array $data, $codIspb, $codAgencia, $nroConta, $tipoConta, $cpfCnpj, $uuidBloqueioDevolucaoEspecial)
  {
    $responseData = $this->request('GET', "/gi/eb/conta/saldo_conta/{$codIspb}/{$codAgencia}/{$nroConta}/{$tipoConta}/{$cpfCnpj}/{$uuidBloqueioDevolucaoEspecial}", $data);

    return [
      'saldoBloq' => $responseData->data->saldoBloq,
      'nroErro' => $responseData->data->nroErro,
      'saldoDisp' => $responseData->data->saldoDisp,
      'saldoTotal' => $responseData->data->saldoTotal,
      'mensagemErro' => $responseData->data->mensagemErro,
    ];
  }

  public function accountTransaction(array $data)
  {
    $responseData = $this->request('POST', "/gi/eb/conta/movimento", $data);

    return [
      'erro' => $responseData->data->erro,
      'nroMovimento' => $responseData->data->nroMovimento,
      'mensagemErro' => $responseData->data->mensagemErro,
      'campoExtra' => $responseData->data->campoExtra,
    ];
  }

  public function accountReceiverValidator(array $data)
  {
    $responseData = $this->request('POST', "/gi/eb/conta/valida_conta_recebedor", $data);

    return [
      "nroConta" => $responseData->data->nroConta,
      "codAgencia" => $responseData->data->codAgencia,
      "erros" => $responseData->data->erros,
      "tipoConta" => $responseData->data->tipoConta,
      "status" => $responseData->data->status
    ];
  }
}