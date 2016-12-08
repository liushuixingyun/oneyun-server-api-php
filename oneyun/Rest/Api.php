<?php

namespace Oneyun\Rest;

use Oneyun\Domain;

class Api extends Domain
{
    protected $_api;

    protected $_call;
    protected $_voiceCall;
    protected $_noticeCall;
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

    protected function getVoiceCall()
    {
        if (!$this->_voiceCall) {
            $this->_voiceCall = new Api\voiceCall($this);
        }
        return $this->_voiceCall;
    }

    protected function getNoticeCall()
    {
        if (!$this->_noticeCall) {
            $this->_noticeCall = new Api\NoticeCall($this);
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