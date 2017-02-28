# 管理API

## 子帐号管理

### 新增子账号 [ok]

```php
<?php
require __DIR__."/vendor/autoload.php";

$appId = ""; //应用标识

$certId = ""; //鉴权Id

$apiUrl = ""; //接口地址

$secreKey = "";//密钥

$oneyun = new Oneyun\Rest\Client($appId, $certId, $apiUrl, $secreKey);

$options = [
    'callbackUrl' => 'http://101.200.135.23:8088/callback/1',
    'remark'=>'test3',
    'quotas' =>[]
];

$res = $oneyun->management->createSubAccount($options);

var_dump($res); //返回结果

```



