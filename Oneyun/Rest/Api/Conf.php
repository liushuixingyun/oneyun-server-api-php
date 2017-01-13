<?php
namespace Oneyun\Rest\Api;

use Oneyun\Exceptions\OptionsException;
use Oneyun\Version;
use Oneyun\Domain;
use Oneyun\Common\Values;

class Conf extends Version
{

    //创建会议
    const  CONF_CEATE = "conf/create";
    //解散会议
    const CONF_DISMISS = "conf/dismiss/{conf_id}";
    //会议邀请呼叫
    const CONF_INVITE_CALL = "conf/invite_call/{conf_id}";
    //将通话加入到会议
    const CONF_JOIN = "conf/join/{conf_id}";
    //从会议退出
    const CONF_QUIT = "conf/quit/{conf_id}";
    //会议放音
    const CONF_START_PLAY = "/conf/start_play/{conf_id}";
    //会议开始录音
    const CONF_START_RECORD = "/conf/start_record/{conf_id}";
    //会议停止录音
    const CONF_STOP_RECORD = "/conf/stop_record/{conf_id}";
    //设置会议成员录放音模式
    const CONF_SET_VOICE_MODEL = "/conf/set_voice_mode/{conf_id}";

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }


}