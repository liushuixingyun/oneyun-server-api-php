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

### 修改子账号 
```php
$id = ''; // 子账号ID
$options = array(
    'callbackUrl'=>'http://...', // 回调url
    'remark'=> '', // 备注
    'enabled'=>1 // 是否启用
);
$res = $oneyun->callcenter->editSubAccount($id,$options);
```

### 删除子账号 
```php
$id = ''; // 子账号ID
$res = $oneyun->callcenter->deleteSubAccount($id);
```

### 查询子帐号列表 
```php
$pageNo = 1;
$pageSize = 20;
$res = $oneyun->callcenter->findAllSubAccount($pageNo,$pageSize);
```

### 子账号详情 
$pageNo = 1;
$pageSize = 20;
```php
$id = ''; // 子账号ID
$res = $oneyun->callcenter->findSubAccount($id);
```

### 设置子账号配额 

```php
$id = ''; // 子账号ID
$quotas = array(
    array(
        'type'=>'AgentQuota', // 呼叫中心坐席配额
        'value'=>1000
    ),
    array(
        'type'=>'CallQuota', // 通话时长配额
        'value'=>1000
    ),
    array(
         'type'=>'ussdQuota', // 闪印配额
         'value'=>1000
    ),
    array(
          'type'=>'smsQuota', // 短信配额
          'value'=>1000
    )
);
$res = $oneyun->callcenter->setSubAccountQuotas($id,$quotas);
```
### 查询号码列表

 ```php
 $pageNo = 1;
 $pageSize = 20;
 $res = $oneyun->callcenter->findAllTelNum($pageNo,$pageSize);
 ```
 
 ### 查询号码列表
 
  ```php
  $pageNo = 1;
  $pageSize = 20;
  $res = $oneyun->callcenter->findAllTelNum($pageNo,$pageSize);
  ```

 ### 号码绑定子账号
 
  ```php
  $id = ''; // 号码资源ID
  $subaccountId = ''; // 子账号ID
  $res = $oneyun->callcenter->bindTelNum($id,$subaccountId);
  ```
 ### 号码解绑子账号

  ```php
  $id = ''; // 号码资源ID
  $subaccountId = ''; // 子账号ID
  $res = $oneyun->callcenter->unBindTelNum($id,$subaccountId);
  ```








