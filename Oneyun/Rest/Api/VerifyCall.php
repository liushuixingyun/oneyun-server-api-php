<?php

namespace Oneyun\Rest\Api;

use Oneyun\Domain;
use Oneyun\Version;
use Oneyun\Common\Values;

class VerifyCall extends Version
{

    /**
     *  语音验证码 address
     */
    const  CALL_CAPTCHA_CALL = "call/verify_call";

    function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    /**
     * @param null $to
     * @param null $verify_code
     * @param array $options
     * @return array
     */
    public function create($to = null,$verify_code = null,$options = array()){

        //初始化默认值
        $voiceCall =  VerifyCallOptions::create();

        //验证码提示音文件名 格式: 文件名1 | 文件名2
        if(isset($options['play_file']) && is_array($options['play_file'])){
            $options['play_file'] = implode("|",$options['play_file']);
        }

        //合并数组
        $options = array_merge($voiceCall->getOptions(),$options);

        //过滤参数
        $options = new Values($options);

        //取值
        $data = Values::of(array(
            'from' => $options['from'],
            'to' => $to,
            'repeat' => $options['repeat'],
            'max_dial_duration' => $options['max_dial_duration'],
            'play_file' => $options['play_file'],
            'verify_code' => $verify_code,
            'user_data' => $options['user_data']
        ));

        $response = $this->request('POST',$this->getBaseUrl().self::CALL_CAPTCHA_CALL ,array(),$data);

        return array(
            'statusCode'=>$response->getStatusCode(),
            'headers'=>$response->getHeaders(),
            'content'=>$response->getContent()
        );
    }



}