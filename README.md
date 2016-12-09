#ONEYUN PHP SDK

#Installation
```php
composer require oneyun/sdk
```
##Quickstart

###语音回拨
示例
```php
<?php

require __DIR__."/vendor/autoload.php";

$appId = ""; //应用标识

$certId = ""; //鉴权Id

$apiUrl = ""; //接口地址

$secreKey = "";//密钥

$oneyun = new Oneyun\Rest\Client($appId, $certId, $apiUrl, $secreKey);

$res = $oneyun->calls->create(
    '17606661993',
    '13611460986',
    array(
        'user_data'=>'',
        'max_dial_duration'=>30
    )
);

var_dump($res); //返回结果

```

###语音通知
示例
```php
<?php

//动态播放内容

$play_content = array(
      array(date('Y-m-d H:i:s'),4,'')
);

$res = $oneyun->notify->create(
    '17606661993',
    $play_content,
    array(
        'user_data'=>'',
        'max_dial_duration'=>30,
        'play_file'=>'语音通知.wav'
    )
);

var_dump($res); //返回结果

```

###语音验证码
示例
```php
<?php

$res = $oneyun->verfiy->create(
    '17606661993',
    '8888',
    array(
        'user_data'=>'',
        'max_dial_duration'=>30
    )
);

var_dump($res); //返回结果

```

###IVR呼出
示例
```php
<?php

$res = $oneyun->verfiy->create(
    '17606661993',
    '8888',
    array(
        'user_data'=>'',
        'max_dial_duration'=>30
    )
);

var_dump($res); //返回结果

```


###IVR


###默认值
| 功能块     | 参数   | 默认值                         |
| ---------   | ------- | ----------------------------- |
|  语音回拨   | `max_call_duration` 最大通话时长（秒）   |      ?     |
|  IVR呼出    | `max_call_duration`  最大接通时间（秒）  |       ?    |



