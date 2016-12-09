<?php

namespace Oneyun\Rest\Api;

use Oneyun\Domain;
use Oneyun\Exceptions\OptionsException;
use Oneyun\Version;
use Oneyun\Common\Values;

class IvrCall extends Version
{
    //Ivr 呼出
    const  IVR_CALL = "call/ivr_call";

    function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    public function create($to = null,$options = array()){

        if(!$to){
            throw new OptionsException('被叫号码必填');
        }

        //初始化默认值
        $notifyCall =  IvrCallOptions::create();

        //合并数组
        $options = array_merge($notifyCall->getOptions(),$options);

        //过滤参数
        $options = new Values($options);

        //取值
        $data = Values::of(array(
            'from' => $options['from'],
            'to' => $to,
            'max_dial_duration' => $options['max_dial_duration'],
            'max_call_duration' => $options['max_call_duration'],
            'user_data' => $options['user_data']
        ));

        //请求
        $response = $this->request('POST',$this->getBaseUrl().self::IVR_CALL ,array(),$data);

        return array(
            'statusCode'=>$response->getStatusCode(),
            'headers'=>$response->getHeaders(),
            'content'=>$response->getContent()
        );
    }



}