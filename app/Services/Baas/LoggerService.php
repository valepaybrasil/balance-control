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
    $responseData = $this->request('GET', '/arch/logger');

    return $responseData->data->list;
  }

  public function getLoggerDetail(string $logger)
  {
    $responseData = $this->request('GET', "/arch/logger/{$logger}");

    return [
      'level' => $responseData->data->level,
      'name' => $responseData->data->name
    ];
  }

  public function create(array $data)
  {
    $responseData = $this->request('POST', '/arch/logger', $data);

    return [
      'level' => $responseData->data->level,
      'name' => $responseData->data->name
    ];
  }
}