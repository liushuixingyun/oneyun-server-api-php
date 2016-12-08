<?php

namespace Oneyun\Rest\Api;

use Oneyun\Domain;
use Oneyun\Version;
use Oneyun\Common\Values;

class NotifyCall extends Version
{
    //语音通知
    const  CALL_NOTIFY_CALL = "call/notify_call";

    function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    public function create($to = null,$play_content = null,$options = array()){

        //初始化默认值
        $notifyCall =  NotifyCallOptions::create();

        //验证码提示音文件名 格式: 文件名1 | 文件名2
        if(isset($options['play_file']) && is_array($options['play_file'])){
            $options['play_file'] = implode("|",$options['play_file']);
        }

        //合并数组
        $options = array_merge($notifyCall->getOptions(),$options);

        //过滤参数
        $options = new Values($options);

        //取值
        $data = Values::of(array(
            'from' => $options['from'],
            'to' => $to,
            'repeat' => $options['repeat'],
            'max_dial_duration' => $options['max_dial_duration'],
            'play_file' => $options['play_file'],
            'play_content' => $play_content,
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