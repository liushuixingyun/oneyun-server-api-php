<?php

namespace Oneyun\Rest\Api;

use Oneyun\Domain;
use Oneyun\Version;
use Oneyun\Common\Values;

class IvrCall extends Version
{
    //Ivr 呼出
    const  CALL_NOTIFY_CALL = "call/notify_call";

    function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    public function create($from = null,$to = null,$options = array()){
        
        //初始化默认值
        $notifyCall =  IvrCallOptions::create();

        //合并数组
        $options = array_merge($notifyCall->getOptions(),$options);

        //过滤参数
        $options = new Values($options);

        //取值
        $data = Values::of(array(
            'from' => $from,
            'to' => $to,
            'repeat' => $options['repeat'],
            'max_dial_duration' => $options['max_dial_duration'],
            'max_call_duration' => $options['max_call_duration'],
            'user_data' => $options['user_data']
        ));

        //请求
        $response = $this->request('POST',$this->getBaseUrl().self::CALL_CAPTCHA_CALL ,array(),$data);

        return array(
            'statusCode'=>$response->getStatusCode(),
            'headers'=>$response->getHeaders(),
            'content'=>$response->getContent()
        );
    }



}