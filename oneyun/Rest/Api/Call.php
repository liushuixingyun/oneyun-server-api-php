<?php
namespace Oneyun\Rest\Api;

use Oneyun\Values;
use Oneyun\Domain;
use Oneyun\Version;

class Call extends Version
{
    const  CALL_URL = "call/duo_callback";
    const  CALL_CANCEL_URL = "call/duo_callback_cancel";

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    public function create($to1 = null, $to2 = null, $options = array())
    {

        //初始化默认值
        $call = CallOptions::create();

        //合并数组
        $options = array_merge($call->getOptions(),$options);

        //过滤参数
        $options = new Values($options);

        //取值
        $data = Values::of(array(
            'from1' => $options['from1'],
            'to1' => $to1,
            'from2' => $options['from2'],
            'to2' => $to2,
            'ring_tone' => $options['ring_tone'],
            'ring_tone_mode' => $options['ring_tone_mode'],
            'max_dial_duration' => $options['max_dial_duration'],
            'max_call_duration' => $options['max_call_duration'],
            'recording' => $options['recording'],
            'record_mode' => $options['record_mode'],
            'user_data' => $options['user_data']
        ));

        $this->request('POST',$this->getBaseUrl().self::CALL_URL ,array(),$data);

    }

    public function cancel($callId){

    }
}