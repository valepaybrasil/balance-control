<?php

namespace App\Services\Baas;


use App\Traits\RequestService;


class LoggerService
{
  use RequestService;

  public $baseUri;
  public $secret;


  public function __construct()
  {
    $this->baseUri = config('microservices.baas.base_uri');
    $this->secret = config('microservices.baas.secret');
  }


  public function getLogger()
  {
    return $this->request('GET', '/arch/logger');
  }

  public function getLoggerDetail(string $logger)
  {
    return $this->request('GET', "/arch/logger/{$logger}");
  }

  public function create(array $data)
  {
    return $this->request('POST', '/arch/logger', $data);
  }
}