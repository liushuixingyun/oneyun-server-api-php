<?php

require __DIR__ . "/vendor/autoload.php";
use Oneyun\Rest\Client;
use Oneyun\Ivr;

//语音验证码测试

// 生产环境

$appId = "8af48114577506f30157755b273a0017";

$certId = "ca7432850f02a8b3bea499cd630aa233";

$apiUrl = "https://api.yunhuni.com/v1/account/ca7432850f02a8b3bea499cd630aa233/";

$secreKey = "062573d7c6bc553dab64da28f9bab426";

//测试环境

$appId = "8a2a6a4a58b9c19d0158bd76a9310000";

$certId = "0c2794d1e1ac22a802f697be8aa70bc8";

$apiUrl = "http://api.yunhuni.cn/v1/account/0c2794d1e1ac22a802f697be8aa70bc8/";

$secreKey = "b7496195f464a00fa6b3fca72f672928";

$oneyun = new Oneyun\Rest\Client($appId, $certId, $apiUrl, $secreKey);

try {

//    $result = $oneyun->ivrCall->create(
//        '13611460986',
//        array(
//            'user_data'=>'',
//            'max_dial_duration'=>30
//        )
//    );



     $response = new Oneyun\Ivr();

     $response->pause(array('timeout'=>2));

     echo $response;


     //$response->connect(array('test.wav','1.wav'),array('max_duration'=>2));

//     $response->get(array('test'=>1));

//    $response = new Oneyun\Ivr();
//
//    $response->get('1',
//        array(
//            'valid_keys' => '0123456789#',
//            'finish_keys' => '#'
//        )
//    );
//    $response->next('localhost');
//



//语音通知测试成功
//$play_content = array(
//    array(date('Y-m-d H:i:s'),4,'')
//);
//
//$result = $oneyun->notifyCall->create(
//    '13611460986',
//    $play_content,
//    array(
//        'user_data'=>'',
//        'max_dial_duration'=>30
//    )
//);

} catch (Exception $e) {
    echo $e->getMessage();
}




//IVR呼出测试成功
//$result = $oneyun->ivrCall->create(
//    '17606661993',
//    array(
//        'user_data'=>'',
//        'max_dial_duration'=>30
//    )
//);


//语音通知测试成功
//$play_content = array(
//    array(date('Y-m-d H:i:s'),4,'')
//);
//


//$result = $oneyun->notifyCall->create(
//    '17606661993',
//    $play_content,
//    array(
//        'user_data' => '',
//        'max_dial_duration' => 30
//    )
//);


//语音验证码测试成功
//$result = $oneyun->verifyCall->create(
//    '13611460986',
//    '0123456',
//     array(
//         'user_data'=>'',
//         'max_dial_duration'=>30
//     )
//);


//生成phpdoc 命令
// phpdoc -d D





