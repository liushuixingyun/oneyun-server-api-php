#ONEYUN PHP SDK

#Installation
```php
composer require oneyun/sdk
```
##Quickstart

###语音回拨
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
```php
<?php

//动态播放内容
$play_content = array(
      array(date('Y-m-d H:i:s'),4,'')
);

$oneyun->notifyCall->create(
    '17606661993',
    $play_content,
    array(
        'user_data'=>'',
        'max_dial_duration'=>30,
        'play_file'=>'语音通知.wav'
    )
);


```

###语音验证码
```php
<?php

$oneyun->verfiyCall->create(
    '17606661993',
    '8888',
    array(
        'user_data'=>'',
        'max_dial_duration'=>30
    )
);

```

###IVR呼出
```php
<?php

$oneyun->ivrCall->create(
    '17606661993',
    array(
        'user_data'=>'',
        'max_dial_duration'=>30
    )
);

```


###IVR

####放音

> play示例

```
<?php
require __DIR__."/vendor/autoload.php";

$ivr = new Oneyun\Ivr();
$ivr->play('文件名.wav');
$ivr->next('http://localhost/ivr.php?step=hangup');
//输出
echo $ivr;
```

输出结果
```
<?xml version="1.0" encoding="UTF-8"?>
<response>
  <play>文件名.wav</play>
  <next>http://localhost/ivr.php?step=hangup</next>
</response>
```


> playlist示例
```php
$ivr = new Oneyun\Ivr();
$ivr->playlist(
    array(
        '文件名1.wav',
        '文件名2.wav'
    )
);
$ivr->next('http://localhost/ivr.php?step=hangup');

echo $ivr;
```

输出结果
```
<?xml version="1.0" encoding="UTF-8"?>
<response>
  <playlist>
    <play>文件名1.wav</play>
    <play>文件名2.wav</play>
  </playlist>  
  <next>http://localhost/ivr.php?step=hangup</next>
</response>
```


####录音
> record示例
```php
$ivr = new Oneyun\Ivr();
$ivr->record();
$ivr->next('http://localhost/ivr.php?step=hangup');

echo $ivr;
```
输出结果
```
<?xml version="1.0" encoding="UTF-8"?>
<response>
  <record></record>  
  <next>http://localhost/ivr.php?step=hangup</next>
</response>
```



####收码
> get示例
```php
$ivr = new Oneyun\Ivr();
$ivr->get(
  'get.wav',
  array(
    'valid_keys'=>'0123456789#',
    'finish_keys'=>'#'
  )
);
$ivr->next('http://localhost/ivr.php?step=hangup');

echo $ivr;
```

输出结果
```
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <get valid_keys="0123456789#" finish_keys="#">
        <play>get.wav</play>
    </get>
    <next>http://localhost/ivr.php?step=hangup</next>
</response>
```


####挂断
> hangup示例
```
$ivr = new Oneyun\Ivr();
$ivr->hangup();

echo $ivr;
```

输出结果
```
<?xml version="1.0" encoding="UTF-8"?>
<response>
  <hangup></hangup>
</response>
```




####拨号
> dial示例
```
$ivr = new Oneyun\Ivr();

$ivr->dial('17606661993');
$ivr->next('http://localhost/ivr.php?step=hangup');

echo $ivr;
```

输出结果
```
<?xml version="1.0" encoding="UTF-8"?>
<response>
  <dial>
    <number>17606661993</number>
    <connect><connect/>
  </dial>
  <next>http://localhost/ivr.php?step=hangup</next>
</response>
```

####后续
> next示例
```php
$ivr = new Oneyun\Ivr();
$ivr->next();
```

