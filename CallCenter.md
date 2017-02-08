# 呼叫中心

## 分机

### 新建分机 [ok]

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

### 删除分机 [ok]
```php
$extension_id = '8a2a6a4a59965bab0159968f95840000';
$res = $oneyun->callcenter->deleteExt($extension_id);
```

### 查看一个分机 [ok]


```php
$extension_id = '8a2a6a4a59965bab0159968f95840000';
$res = $oneyun->callcenter->findExt($extension_id);
```

### 查看分机列表 [ok]
```php
$res = $oneyun->callcenter->findAllExt($pageNo,$pageSize);
```

## 坐席

### 坐席登录 [ok]
```php
$res = $oneyun->callcenter->agentLogin($name,$channel,$extension,$options);
```

### 坐席注销
```php
$res = $oneyun->callcenter->agentLogout($name = '',$force = false);
```

### 坐席报到 
```php
$res = $oneyun->callcenter->agentKeep($name = '');
```

### 获取单个坐席信息 [ok]
```php
$res = $oneyun->callcenter->findAgent($name = '');
```

### 获取坐席信息列表 [ok]
```php
$res = $oneyun->callcenter->findAllAgent($pageNo = 1,$pageSize = 10);
```

### 设置坐席分机 [ok]
```php
$res = $oneyun->callcenter->setAgentExt($agent_name,$ext_id )
```

### 设置坐席状态 [ok]
```php
$res = $oneyun->callcenter->setAgentState($agent_name,$state);
```

### 设置坐席技能 [ok]
```php
$res = $oneyun->callcenter->setAgentSkills($agent_name,$opts);

```

## 工作通道

### 新建工作通道 [ok]
```php
$res = $oneyun->callcenter->createChannel($max_agent, $max_skill, $max_condition, $max_queue, $options);

```

### 删除工作通道 [ok]
```php
$res = $oneyun->callcenter->deleteChannel($channel_id);

```

### 修改工作通道 [ok]
```php
$res = $oneyun->callcenter->editChannel($max_agent, $max_skill, $max_condition, $max_queue, $options);
```

### 获取单条工作通道 [ok]
```php
$res = $oneyun->callcenter->findChannel($channel_id);

```

### 获取多条工作通道 [ok]
```php
$res = $oneyun->callcenter->findAllChannel();
```

## 排队条件

### 新建排队条件 [ok]
```php
$res = $oneyun->callcenter->createCondition($channe,$where,$options);
```

### 删除排队条件 [ok]
```php
$res = $oneyun->callcenter->deleteChannel($channel_id);
```

### 修改排队条件 [ok]
```php
$res = $oneyun->callcenter->editCondition($condition_id,$channe,$where,$options);
```

### 获取单条排队条件 [ok]
```php
$res = $oneyun->callcenter->findCondition($channel_id);
```

### 获取多条排队条件 [ok]
```php
$res = $oneyun->callcenter->findAllCondition();
```

## 交谈

### 解散交谈
```php
$res = $oneyun->callcenter->deleteConversation($conversation_id);
```

### 设置呼叫听说模式
```php
$res = $oneyun->callcenter->setConversationMode($conversation_id,$agent_name,$mode);
```

### 邀请坐席加入
```php
$res = $oneyun->callcenter->setConversationInviteAgent($conversation_id,$enqueue,$mode);
```

### 邀请外线加入
```php
$res = $oneyun->callcenter->setConversationInviteOut($conversation_id,$to,$max_answer_seconds,$options);
```

### 获取交谈单条记录 
```php
$res = $oneyun->callcenter->findConversation($conversation_id);
```

### 获取交谈列表
```php
$res = $oneyun->callcenter->findAllConversation();
```

## 坐席操作

### 坐席拒绝排队任务
```php
$res = $oneyun->callcenter->setAgentRejectTask($agent_name,$queue_id,$data);
```

### 呼叫外线
```php
$res = $oneyun->callcenter->setAgentCallOut($agent_name,$to,$max_answer_seconds,$options);
```

### 呼叫其它坐席
```php
$res = $oneyun->callcenter->setAgentCallAgent($agent_name,$enqueue);
```

### 前转到其它坐席
```php
$res = $oneyun->callcenter->setAgentFwdAgent($agent_name,$queue_task_id,$enqueue);
```

### 后转到其它坐席
```php
$res = $oneyun->callcenter->setAgentXferAgent($agent_name,$conversation_id,$enqueue);
```

### 后转到外线
```php
$res = $oneyun->callcenter->setAgentXferOut($agent_name,$conversation_id,$to,$max_answer_seconds,$options);
```

### 设置听说模式
```php
$res = $oneyun->callcenter->setAgentMode($agent_name,$conversation_id,$mode);
```

### 坐席加入交谈
```php
$res = $oneyun->callcenter->setAgentEnter($agent_name,$conversation_id,$mode,$holding);
```

### 坐席退出交谈
```php
$res = $oneyun->callcenter->setAgentOut($agent_name,$conversation_id);
```

### 合并交谈
```php
$res = $oneyun->callcenter->setAgentMerge($agent_name,$src_conversation_id,$dst_conversation_id,$mode);
```

### 获取坐席所在交谈列表
```php
$res = $oneyun->callcenter->findAgentConversation($agent_name);
```






