<?php
namespace Oneyun\Rest;

use Oneyun\Client as HttpClient;
use Oneyun\Http\CurlClient;
use Oneyun\Common\Encrypt;

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
        if (!$this->appId || !$this->certId || !$this->apiUrl || !$this->secreKey) {
            throw  new OneyunException('Credentials are required to create a Client');
        }

        if ($httpClient) {
            $this->httpClient = $httpClient;
        } else {
            $this->httpClient = new CurlClient();
        }
    }

    /**
     * Makes a request to the Twilio API using the configured http client
     * Authentication information is automatically added if none is provided
     *
     * @param string $method HTTP Method
     * @param string $uri Fully qualified url
     * @param string[] $params Query string parameters
     * @param string[] $data POST body data
     * @param string[] $headers HTTP Headers
     * @param int $timeout Timeout in seconds
     * @return \Oneyun\Http\Response Response from the Twilio API
     */
    public function request($method = null, $uri = null, $params = array(), $data = array(), $headers = array(), $timeout = null)
    {

        //应用标识
        $headers['AppID'] = $this->appId;

        //密钥
        $headers['CertID'] = $this->certId;

        //当前时间
        $headers['Timestamp'] = date('YmdHis', time());

        //实体头
        if ($method == 'POST' && !array_key_exists('Content-Type', $headers)) {
            $headers['Content-Type'] = 'application/json; charset=utf-8';
        }

        //请求头
        if (!array_key_exists('Accept', $headers)) {
            $headers['Accept'] = 'application/json';
        }

        //签名加密
        $signature = Encrypt::create('POST', json_encode($data), $headers['Content-Type'], $headers['Timestamp'], $this->appId, parse_url($uri, PHP_URL_PATH), $this->secreKey);

        if (!array_key_exists('Signature', $headers)) {
            $headers['Signature'] = $signature;
        }

        return $this->getHttpClient()->request(
            $method,
            $uri,
            $params,
            $data,
            $headers,
            $timeout
        );
    }

    function __autoload($class)
    {
        $file = $class . '.php';
        if (is_file($file)) {
            require_once($file);
        }
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

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return Api 接口
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new Exception('Unknown domain ' . $name);
    }

}

