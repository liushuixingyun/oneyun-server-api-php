<?php

namespace Oneyun\Rest;

require 'Api/Call.php';
require 'Api/IvrCall.php';
require 'Api/NoticeCall.php';
require 'Api/VoiceCall.php';


class Api
{

    protected $_api;

    private $_call;
    protected $_voiceCall;
    protected $_noticeCall;
    protected $_ivrCall;


    function getCall()
    {
         if (!$this->_call) {
            $this->_call = new Api\Call();
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

    protected function  getNoticeCall()
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

    function __get($name){
        $method = "get". ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

}