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


$options = array(
    'type'=>1, // 分机类型
    'user'=>'test001', // 分机号 6-12位数字
    'password'=>'123456' // 分机密码
);

$res = $oneyun->callcenter->createExt($options);

var_dump($res); //返回结果

```

### 删除分机 [ok]
```php
$extension_id = '8a2a6a4a59965bab0159968f95840000'; // 分机ID
$res = $oneyun->callcenter->deleteExt($extension_id);
```

### 查看一个分机 [ok]
```php
$extension_id = '8a2a6a4a59965bab0159968f95840000'; // 分机ID
$res = $oneyun->callcenter->findExt($extension_id);
```

### 查看分机列表 [ok]
```php
$pageNo = 1; // 第几页
$pageSize = 20; // 每页显示数量
$res = $oneyun->callcenter->findAllExt($pageNo,$pageSize);
```

## 坐席

### 坐席登录 [ok]

```php
$agent_name = 'test001'; //坐席名称
$extension = '8a2a6a4a59965bab0159968f95840000'; // 绑定的分机ID
$options = array(
    'num'=>'123456', // 坐席工号
    'state'=>'idle' // 坐席状态 idle 为空闲
);

$res = $oneyun->callcenter->agentLogin($agent_name,$extension,$options);
```

### 坐席注销
```php
$agent_name = 'test001'; //坐席名称
$force = true; // true 为强制注销
$res = $oneyun->callcenter->agentLogout($agent_name,$force);
```

### 坐席报到 
```php
$agent_name = 'test001'; //坐席名称
$res = $oneyun->callcenter->agentKeep($agent_name);
```

### 获取单个坐席信息 [ok]
```php
$agent_name = 'test001'; //坐席名称
$res = $oneyun->callcenter->findAgent($agent_name);
```

### 获取坐席信息列表 [ok]
```php
$pageNo = 1; // 第几页
$pageSize = 20; // 每页显示数量
$res = $oneyun->callcenter->findAllAgent($pageNo, $pageSize);
```

### 设置坐席分机 [ok]
```php
$agent_name = 'test001'; //坐席名称
$extension_id = '8a2a6a4a59965bab0159968f95840000'; // 分机ID
$res = $oneyun->callcenter->setAgentExt($agent_name,$extension_id )
```

### 设置坐席状态 [ok]
```php
$agent_name = 'test001'; //坐席名称
$state = 'idle'; // 坐席状态
$res = $oneyun->callcenter->setAgentState($agent_name,$state);
```

### 设置坐席技能 [ok]
```php
$agent_name = 'test001'; //坐席名称

// 坐席技能
$opts = array( 
    array(
        'opt'=>1,
        'name'=>'test', // 坐席名称
        'score'=>80, // 坐席技能分
        'enabled'=>true // 是否启用技能
    )
); 
$res = $oneyun->callcenter->setAgentSkills($agent_name,$opts);

```

## 排队条件

### 新建排队条件 [ok]
```php
// public function createCondition($where = '', $queue_timeout = 0,$options = array())
$where = 'get('test')>60;'; // 条件表达式  必须;号结尾
$queue_timeout = 30; // 排队等待超时时间 (0-1000)
$options = array(
    'fetch_timeout'=>30, // 坐席分机接听超时时间(秒)(0-60)
    'priority'=>99, // 数值大的优先级高 (0-99)
    'remark'=>'', // 备注
);

$res = $oneyun->callcenter->createCondition($where,$queue_timeout,$options);
```

### 删除排队条件 [ok]
```php
$condition_id = ''; // 排队条件
$res = $oneyun->callcenter->deleteCondition($condition_id);
```

### 修改排队条件 [ok]
```php
$condition_id = ''; //排队条件ID
$where = 'get('test')>60;'; // 条件表达式  必须;号结尾
$options = array(
    'fetch_timeout'=>30, // 坐席分机接听超时时间(秒)(0-60)
    'priority'=>99, // 数值大的优先级高 (0-99)
    'remark'=>'', // 备注
);
$res = $oneyun->callcenter->editCondition($condition_id,$where,$options);
```

### 获取单条排队条件 [ok]
```php
$condition_id = ''; //排队条件ID
$res = $oneyun->callcenter->findCondition($condition_id);
```

### 获取多条排队条件 [ok]
```php
$res = $oneyun->callcenter->findAllCondition();
```

## 交谈

### 
```php
$conversation_id = ''; // 交谈ID
$res = $oneyun->callcenter->deleteConversation($conversation_id);
```

### 设置呼叫听说模式
```php
$conversation_id = '';  // 交谈ID
$agent_name = ''; // 坐席名称
$mode = 1; // 设置坐席听说模式 (1-4)
$res = $oneyun->callcenter->setConversationMode($conversation_id,$agent_name,$mode);
```

### 邀请坐席加入
```php
$conversation_id = '';  // 交谈ID
$enqueue = '<enqueue wait_voice="wait.wav" ring_mode="1" play_num="true" user_data="test">
                <route><agent name="test001" priority="11" queue_timeout="60" fetch_timeout="50"></agent></route>
            </enqueue>'; // 目标坐席选择条件
$mode = 1; // 设置坐席听说模式 (1-4)
$res = $oneyun->callcenter->setConversationInviteAgent($conversation_id,$enqueue,$mode);
```

### 邀请外线加入
```php
$conversation_id = '';  // 交谈ID
$to = '17606661993'; // 被叫号码
$max_answer_seconds = 180; // 最大通话时间
$options = array(
    'from'=>'', // 主叫号码
    'max_dial_seconds' => 60, // 最大拨号等待时间
    'mode'=>1 // 加入后的听/说模式
);
$res = $oneyun->callcenter->setConversationInviteOut($conversation_id,$to,$max_answer_seconds,$options);
```

### 获取交谈单条记录 
```php
$conversation_id = '';  // 交谈ID
$res = $oneyun->callcenter->findConversation($conversation_id);
```

### 获取交谈列表
```php
$res = $oneyun->callcenter->findAllConversation();
```

## 坐席操作

### 坐席拒绝排队任务
```php
$agent_name = 'test001'; // 坐席名称
$queue_id = ''; // 排队任务ID
$data =  'user_data'; // 自定义数据
$res = $oneyun->callcenter->setAgentRejectTask($agent_name,$queue_id,$data);
```

### 坐席呼叫外线
```php
$agent_name = 'test001'; // 坐席名称
$to = '17606661993'; // 被叫号码
$max_answer_seconds = 180; // 最大通话时间
$options = array(
    'from'=>'', // 主叫号码
    'max_dial_seconds' => 60, // 最大拨号等待时间
    'user_data'=>'自定义数据' 
);
$res = $oneyun->callcenter->setAgentCallOut($agent_name,$to,$max_answer_seconds,$options);
```

### 坐席呼叫其它坐席
```php
$agent_name = 'test001'; // 坐席名称
$enqueue = '<enqueue wait_voice="wait.wav" ring_mode="1" play_num="true" user_data="test">
                <route><agent name="test001" priority="11" queue_timeout="60" fetch_timeout="50"></agent></route>
            </enqueue>'; // 目标坐席选择条件
            
$res = $oneyun->callcenter->setAgentCallAgent($agent_name,$enqueue);
```

### 前转到其它坐席
```php
$agent_name = 'test001'; // 坐席名称
$queue_task_id = '';
$enqueue = '<enqueue wait_voice="wait.wav" ring_mode="1" play_num="true" user_data="test">
                <route><agent name="test001" priority="11" queue_timeout="60" fetch_timeout="50"></agent></route>
            </enqueue>'; // 目标坐席选择条件
$res = $oneyun->callcenter->setAgentFwdAgent($agent_name,$queue_task_id,$enqueue);
```

### 后转到其它坐席
```php
$agent_name = 'test001'; // 坐席名称
$conversation_id = ''; // 交谈ID
$enqueue = '<enqueue wait_voice="wait.wav" ring_mode="1" play_num="true" user_data="test">
                <route><agent name="test001" priority="11" queue_timeout="60" fetch_timeout="50"></agent></route>
            </enqueue>'; // 目标坐席选择条件

$res = $oneyun->callcenter->setAgentXferAgent($agent_name,$conversation_id,$enqueue);
```

### 后转到外线
```php
$agent_name = 'test001'; // 坐席名称
$conversation_id = ''; // 交谈ID
$max_answer_seconds = 180; // 最大通话时间
$options = array(
    'from'=>'', // 主叫号码
 );
$res = $oneyun->callcenter->setAgentXferOut($agent_name,$conversation_id,$to,$max_answer_seconds,$options);
```

### 设置听说模式
```php
$agent_name = 'test001'; // 坐席名称
$conversation_id = ''; // 交谈ID
$mode = 1; // 设置坐席听说模式 (1-4)
$res = $oneyun->callcenter->setAgentMode($agent_name,$conversation_id,$mode);
```

### 坐席加入交谈
```php
$agent_name = 'test001'; // 坐席名称
$conversation_id = ''; // 交谈ID
$mode = 1; // 设置坐席听说模式 (1-4)
$holding = true; 
$res = $oneyun->callcenter->setAgentEnter($agent_name,$conversation_id,$mode,$holding);
```

### 坐席退出交谈
```php
$agent_name = 'test001'; // 坐席名称
$conversation_id = ''; // 交谈ID
$res = $oneyun->callcenter->setAgentOut($agent_name,$conversation_id);
```

### 合并交谈
```php
$agent_name = 'test001'; // 坐席名称
$src_conversation_id = ''; // 交谈ID1
$dst_conversation_id = ''; // 交谈ID2
$mode = 1; // 设置坐席听说模式 (1-4)
$res = $oneyun->callcenter->setAgentMerge($agent_name,$src_conversation_id,$dst_conversation_id,$mode);
```

### 获取坐席所在交谈列表
```php
$agent_name = 'test001'; // 坐席名称
$res = $oneyun->callcenter->findAgentConversation($agent_name);
```






