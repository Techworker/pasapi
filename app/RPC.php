<?php

namespace App;

use Graze\GuzzleHttp\JsonRpc\Client;
use Graze\GuzzleHttp\JsonRpc\Exception\RequestException;

class RPC
{
    protected $client;
    protected $callCounter = 1;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $method, array $params = [])
    {
        try {
            $request = $this->client->request(++$this->callCounter, $method, $params);
            $response = $this->client->send($request);
            $data = json_decode($response->getBody(), true);
            if(isset($data['result'])) {
                return $data['result'];
            }
            return null;
        } catch (RequestException $e) {
            die($e->getResponse()->getRpcErrorMessage());
        }
    }
}