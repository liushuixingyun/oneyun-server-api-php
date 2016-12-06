<?php
namespace Oneyun\Rest;

use Oneyun\Exception;
use Oneyun\Client as HttpClient;
use Oneyun\Http\CurlClient;

require 'Api.php';

Class Client
{

    protected $appId;
    protected $certId;
    protected $apiUrl;
    protected $secreKey;
    protected $httpClient;

    private $_api;
    private $_ivr;

    /**
     *  初始化参数
     */
    function __construct($appId = null, $certId = null, $apiUrl = null, $secreKey = null, $httpClient = array())
    {
        if ($appId) {
            $this->appId = $appId;
        }
        if ($certId) {
            $this->certId = $certId;
        }
        if ($apiUrl) {
            $this->apiUrl = $apiUrl;
        }
        if ($secreKey) {
            $this->secreKey = $secreKey;
        }
        if(!$this->appId || !$this->certId || !$this->apiUrl || !$this->secreKey ){
            throw  new OneyunException('Credentials are required to create a Client');
        }

        if ($httpClient) {
            $this->httpClient = $httpClient;
        }

    }


    function __autoload($class)
    {
        $file = $class . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }


    protected function getIvr()
    {
        if (!$this->_ivr) {
            $this->_ivr = new Ivr();
        }
        return $this->_ivr;
    }


    protected function getCalls()
    {
        return $this->api->call;
    }

    protected function getApi()
    {
        if (!$this->_api) {
            $this->_api = new Api($this);
        }
        return $this->_api;
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new OneyunException('Unknown domain ' . $name);
    }

}

