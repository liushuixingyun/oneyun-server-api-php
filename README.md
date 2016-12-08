##explame

```php
<?php
require __DIR__."/vendor/autoload.php";

$appId = "8a2bc672576fb93d01576fc0fbd70003";

$certId = "0c2794d1e1ac22a802f697be8aa70bc8";

$apiUrl = "http://api.yunhuni.cn/v1/account/0c2794d1e1ac22a802f697be8aa70bc8/";

$secreKey = "b7496195f464a00fa6b3fca72f672928";

$oneyun = new Oneyun\Rest\Client($appId, $certId, $apiUrl, $secreKey);

$oneyun->calls->create(
    '17606661993',
    '13611460986',
    array(
        'user_data'=>'',
        'max_dial_duration'=>30
    )
);


```