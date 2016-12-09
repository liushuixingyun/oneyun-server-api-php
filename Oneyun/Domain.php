<?php
namespace Oneyun;

use Oneyun\Rest\Client;

abstract class Domain
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var null
     */
    protected $baseUrl;

    /**
     * Domain constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->baseUrl = $client->apiUrl;
    }

    /**
     * @param null $method
     * @param null $uri
     * @param array $params
     * @param array $data
     * @param array $headers
     * @param null $timeout
     * @return Http\Response
     */
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

    /**
     * @return null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

}