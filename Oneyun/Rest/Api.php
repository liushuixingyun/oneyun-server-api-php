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
    protected $_callCenter;
    protected $_managerment;
    protected $_msg;

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 语音回拨
     * @return Api\Call
     */
    protected function getCall()
    {
        if (!$this->_call) {
            $this->_call = new Api\Call($this);
        }
        return $this->_call;
    }

    /**
     * 语音验证码
     * @return Api\VerifyCall
     */
    protected function getVerifyCall()
    {
        if (!$this->_verifyCall) {
            $this->_verifyCall = new Api\VerifyCall($this);
        }
        return $this->_verifyCall;
    }

    /**
     * 语音通知
     * @return Api\NotifyCall
     */
    protected function getNotifyCall()
    {
        if (!$this->_notifyCall) {
            $this->_notifyCall = new Api\NotifyCall($this);
        }
        return $this->_notifyCall;
    }

    /**
     * IVR外呼
     * @return Api\IvrCall
     */
    protected function getIvrCall()
    {
        if (!$this->_ivrCall) {
            $this->_ivrCall = new Api\IvrCall($this);
        }
        return $this->_ivrCall;
    }

    /**
     * 呼叫中心
     * @return Api\CallCenter\CallCenter
     */
    protected function getCallCenter()
    {
        if (!$this->_callCenter) {
            $this->_callCenter = new Api\CallCenter\CallCenter($this);
        }
        return $this->_callCenter;
    }

    /**
     * 管理API
     * @return Api\Management\Management
     */
    protected function getManagement(){
        if (!$this->_managerment) {
            $this->_managerment = new Api\Management\Management($this);
        }
        return $this->_managerment;
    }

    /**
     * 消息API
     * @return Api\Msg\Msg
     */
    protected function getMsg(){
        if (!$this->_msg) {
            $this->_msg = new Api\Msg\Msg($this);
        }
        return $this->_msg;
    }

    public function __get($name)
    {
        $method = "get" . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

}