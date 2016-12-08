<?php
namespace Oneyun;

use Oneyun\Rest\Client;

abstract class Domain
{
    protected $client;

    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->baseUrl = $client->apiUrl;
    }

    public function request($method = null, $uri = null, $params = array(), $data = array(),
                            $headers = array(), $timeout = null)
    {
        return $this->client->request(
            $method,
            $uri,
            $params,
            $data,
            $headers,
            $timeout
        );
    }

    /**
     * @return \Oneyun\Rest\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

}