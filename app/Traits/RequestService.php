<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;



trait RequestService
{
  public function request($method, $endpoint, $formParams = [], $headers = [])
  {
    try {
      $requestUrl = $this->baseUri . $endpoint;

      $httpClient = new Client();

      if (isset($this->secret)) {
        $headers['Authorization'] = $this->secret;
      }

      $request = new Request($method, $requestUrl, $headers, json_encode($formParams));

      $response = $httpClient->send($request);

      $result = json_decode($response->getBody());

      return $result;
      
    } catch (ClientException $ex) {

      dd($ex->toString());
    }
  }
}
