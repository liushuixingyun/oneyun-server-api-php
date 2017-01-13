# 呼叫中心

## 分机

### 新建分机

```php
<?php
require __DIR__."/vendor/autoload.php";

$appId = ""; //应用标识

$certId = ""; //鉴权Id

$apiUrl = ""; //接口地址

$secreKey = "";//密钥

$oneyun = new Oneyun\Rest\Client($appId, $certId, $apiUrl, $secreKey);

$options = array(
    'type'=>1,
    'user'=>'10222',
    'password'=>'123456'
);

$res = $oneyun->callcenter->createExt($options);

var_dump($res); //返回结果

```

### 删除分机
```php
<?php

$extension_id = '8a2a6a4a59965bab0159968f95840000';

$res = $oneyun->callcenter->deleteExt($extension_id);

var_dump($res); //返回结果

```

### 查看一个分机


```php
<?php

$extension_id = '8a2a6a4a59965bab0159968f95840000';

$res = $oneyun->callcenter->findAllExt($extension_id);

var_dump($res); //返回结果

```

### 查看分机列表


```php
<?php

$pageNo = 1;
$pageSize = 10;

$res = $oneyun->callcenter->findAllExt($pageNo,$pageSize);

var_dump($res); //返回结果

```

## 坐席

### 登录
```php
<?php

$name = null;
$channel = null;
$extension = null;  
$options =array();

$res = $oneyun->callcenter->agentLogin($name,$channel,$extension,$options);

var_dump($res); //返回结果

```

### 注销
```php

$res = $oneyun->callcenter->agentLogout($name = '',$force = false);

var_dump($res); //返回结果

```


### 报到
```php

$res = $oneyun->callcenter->agentKeep($name = '');

var_dump($res); //返回结果

```

### 获取坐席信息
```php

$res = $oneyun->callcenter->agentKeep($name = '');

var_dump($res); //返回结果

```

### 获取单个坐席信息
```php

$res = $oneyun->callcenter->findAgent($name = '');

var_dump($res); //返回结果

```

### 获取坐席信息列表
```php

$res = $oneyun->callcenter->findAllAgent($pageNo = 1,$pageSize = 10);

var_dump($res); //返回结果

```

### 设置坐席分机
```php

$res = $oneyun->callcenter->setAgentExt($agent_name,$ext_id )

var_dump($res); //返回结果

```

### 设置坐席状态
```php

$res = $oneyun->callcenter->setAgentState($agent_name,$state)

var_dump($res); //返回结果

```

### 坐席技能设置
```php
$res = $oneyun->callcenter->setAgentSkills($agent_name,$opts)


    

```



