<?php
namespace Oneyun\Rest;

use Oneyun\Domain;

class Api extends Domain
{
    protected $_api;

    protected $_call;
    protected $_verifyCall;
    protected $_notifyCall;
    protected $_ivrCall;

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    protected function getCall()
    {
        if (!$this->_call) {
            $this->_call = new Api\Call($this);
        }
        return $this->_call;
    }

    protected function getVerifyCall()
    {
        if (!$this->_verifyCall) {
            $this->_verifyCall = new Api\VerifyCall($this);
        }
        return $this->_verifyCall;
    }

    protected function getNotifyCall()
    {
        if (!$this->_notifyCall) {
            $this->_notifyCall = new Api\NotifyCal($this);
        }
        return $this->_noticeCall;
    }

    protected function getIvrCall()
    {
        if (!$this->_ivrCall) {
            $this->_ivrCall = new Api\IvrCall($this);
        }
        return $this->_ivrCall;
    }

    function __get($name)
    {
        $method = "get" . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

}