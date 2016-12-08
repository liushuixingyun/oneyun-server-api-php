<?php

namespace Oneyun;

use Oneyun\Exceptions as RestException;
use Oneyun\Http\Response;

abstract class Version
{
    /**
     * @const int MAX_PAGE_SIZE largest page the Twilio API will return
     */
    const MAX_PAGE_SIZE = 1000;

    /**
     * @var \Oneyun\Domain $domain
     */
    protected $domain;

    /**
     * @var string $version
     */
    protected $version;

    /**
     * @param \Oneyun\Domain $domain
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
        $this->version = null;
    }

    public function getBaseUrl()
    {
        return $this->getDomain()->getBaseUrl();
    }


    public function relativeUri($uri)
    {
        return trim($this->version, '/') . '' . trim($uri, '/');
    }


    public function request($method = null, $uri = null, $params = array(), $data = array(),
                            $headers = array(), $timeout = null)
    {
        $uri = $this->relativeUri($uri);

        return $this->getDomain()->request(
            $method,
            $uri,
            $params,
            $data,
            $headers,
            $timeout
        );
    }


    protected function exception($response, $header)
    {
        $message = '[HTTP ' . $response->getStatusCode() . '] ' . $header;

        $content = $response->getContent();
        if (is_array($content)) {
            $message .= isset($content['message']) ? ': ' . $content['message'] : '';
            $code = isset($content['code']) ? $content['code'] : $response->getStatusCode();
            return new RestException($message, $code, $response->getStatusCode());
        } else {
            return new RestException($message, $response->getStatusCode(), $response->getStatusCode());
        }
    }


    /**
     * @return \Oneyun\Domain $domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    public function __toString()
    {
        return '[Version]';
    }
}
