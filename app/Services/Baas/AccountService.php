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
    return $this->request('POST', '/gi/eb/conta/bloqueio', $data);
  }

  public function blockAccountSpecialRefund(array $data)
  {
    return $this->request('POST', '/gi/eb/conta/bloqueio_devolucao_especial', $data);
  }

  public function unblockAccount(array $data)
  {
    return $this->request('POST', '/gi/eb/conta/desbloqueio', $data);
  }

  public function accountBalance(array $data, string $codIspb, string $codAgencia, string $nroConta, string $tipoConta, string $cpfCnpj)
  {
    return $this->request('GET', "/gi/eb/conta/saldo_conta/{$codIspb}/{$codAgencia}/{$nroConta}/{$tipoConta}/{$cpfCnpj}", $data);
  }

  public function accountBalanceBlockSpecialRefund(array $data, $codIspb, $codAgencia, $nroConta, $tipoConta, $cpfCnpj, $uuidBloqueioDevolucaoEspecial)
  {
    return $this->request('GET', "/gi/eb/conta/saldo_conta/{$codIspb}/{$codAgencia}/{$nroConta}/{$tipoConta}/{$cpfCnpj}/{$uuidBloqueioDevolucaoEspecial}", $data);
  }

  public function accountTransaction(array $data)
  {
    return $this->request('POST', "/gi/eb/conta/movimento", $data);
  }

  public function accountReceiverValidator(array $data)
  {
    return $this->request('POST', "/gi/eb/conta/valida_conta_recebedor", $data);
  }
}