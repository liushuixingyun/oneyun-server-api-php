<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Exceptions\OptionsException;
use Oneyun\Version;
use Oneyun\Domain;
use Oneyun\Common\Values;

class CallCenter extends Version
{
    const CALLCENTER_EXTENSION = "callcenter/extension"; // 分机
    const CALLCENTER_AGENT = "callcenter/agent"; // 坐席
    const CALLCENTER_CONDITION = "callcenter/condition"; // 排队
    const CALLCENTER_CONVERSATION = "callcenter/conversation"; // 交谈

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    /**
     * 新建分机
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function createExt($options = array())
    {
        if (!$options) {
            throw new OptionsException('请填写参数 createExt(array("type"=>1 ,...))');
        }
        $extension = ExtensionOptions::create();
        $options = array_merge($extension->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'type' => $options['type'],
            'user' => $options['user'],
            'password' => $options['password'],
            'ipaddr' => $options['ipaddr'],
            'telnum' => $options['telnum']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_EXTENSION, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 删除分机
     * @param $extension_id
     * @return array
     * @throws OptionsException
     */
    public function deleteExt($extension_id)
    {
        if (empty($extension_id)) {
            throw new OptionsException('分机id必填');
        }
        $response = $this->request('DELETE', $this->getBaseUrl() . self::CALLCENTER_EXTENSION . "/" . $extension_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 查看单个分机信息
     * @param $extension_id
     * @return array
     * @throws OptionsException
     */
    public function findExt($extension_id)
    {
        if (empty($extension_id)) {
            throw new OptionsException('分机Id必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_EXTENSION . "/" . $extension_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 查看分机列表
     * @param $pageNo
     * @param $pageSize
     * @return array
     * @throws OptionsException
     */
    public function findAllExt($pageNo, $pageSize)
    {
        $params = array(
            'pageNo' => $pageNo,
            'pageSize' => $pageSize
        );
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_EXTENSION, $params, array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 登录坐席
     * @param null $name
     * @param $extension
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function agentLogin($name, $extension, $options)
    {
        if (empty($name)) {
            throw new OptionsException('登录必填');
        }
        if (empty($extension)) {
            throw new OptionsException('坐席的分机必填');
        }
        $agent = AgentOptions::create();
        $options = array_merge($agent->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'name' => $name,
            'num' => $options['num'],
            'state' => $options['state'],
            'skills' => $options['skills'],
            'extension' => $extension
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 坐席注销
     * @param null $agent_name
     * @param bool $force
     * @return array
     * @throws OptionsException
     */
    public function agentLogout($agent_name = null, $force = false)
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        $params = array(
            'force' => $force
        );
        $response = $this->request('DELETE', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name, $params, array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     *  坐席报到
     * @param $agent_name
     * @return array
     * @throws OptionsException
     */
    public function agentKeep($agent_name)
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name, "/keepalive", array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取单个坐席信息
     * @param $agent_name
     * @return array
     * @throws OptionsException
     */
    public function findAgent($agent_name)
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取坐席信息列表
     * @param $pageNo
     * @param $pageSize
     * @return array
     */
    public function findAllAgent($pageNo = 1, $pageSize = 20)
    {
        $params = array(
            'pageNo' => $pageNo,
            'pageSize' => $pageSize
        );
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_AGENT, $params, array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 设置坐席分机
     * @param $agent_name
     * @param $extension_id
     * @return array
     * @throws OptionsException
     */
    public function setAgentExt($agent_name, $extension_id)
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        $data = array(
            'id' => $extension_id
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/extension", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 设置坐席状态
     * @param $agent_name
     * @param $state <基本状态>[/扩展状态]
     * @return array
     * @throws OptionsException
     */
    public function setAgentState($agent_name, $state)
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if (empty($state)) {
            throw new OptionsException('状态值字符串必填');
        }
        $data = array(
            'state' => $state
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/state", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 坐席技能设置
     * @param $agent_name
     * @param $opts
     * @return array
     * @throws OptionsException
     */
    public function setAgentSkills($agent_name, $opts)
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if (empty($opts)) {
            throw new OptionsException('技能操作列表必填');
        }
        $data = array(
            'opts' => $opts
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/skills", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 新建排队条件
     * @param $where
     * @param $queue_timeout
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function createCondition($where = '', $queue_timeout = 0,$options = array())
    {
        if (empty($where)) {
            throw new OptionsException('条件表达式必填');
        }
        if ($queue_timeout == 0) {
            throw new OptionsException('排队等待超时时间必填');
        }
        $condition = ConditionOptions::create();
        $options = array_merge($condition->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'where' => $where,
            'sort' => $options['sort'],
            'priority' => $options['priority'],
            'queue_timeout' => $queue_timeout,
            'fetch_timeout' => $options['fetch_timeout'],
            'remark' => $options['remark']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CONDITION, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     *  删除排队条件
     * @param $condition_id
     * @return array
     * @throws OptionsException
     */
    public function deleteCondition($condition_id)
    {
        if (empty($condition_id)) {
            throw new OptionsException('条件Id必填');
        }
        $response = $this->request('DELETE', $this->getBaseUrl() . self::CALLCENTER_CONDITION . "/" . $condition_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 修改排队条件
     * @param string $condition_id
     * @param string $where
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function editCondition($condition_id = '', $where = '', $options = array())
    {
        if (empty($condition_id)) {
            throw new OptionsException('条件Id必填');
        }
        if (empty($where)) {
            throw new OptionsException('条件表达式必填');
        }
        $condition = ConditionOptions::create();
        $options = array_merge($condition->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'where' => $where,
            'sort' => $options['sort'],
            'priority' => $options['priority'],
            'queue_timeout' => $options['queue_timeout'],
            'fetch_timeout' => $options['fetch_timeout'],
            'remark' => $options['remark']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CONDITION . "/" . $condition_id, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取单条排队条件记录
     * @param $condition_id
     * @return array
     * @throws OptionsException
     */
    public function findCondition($condition_id)
    {
        if (empty($condition_id)) {
            throw new OptionsException('排队条件Id必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_CONDITION . "/" . $condition_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取多条排队条件列表
     * @return array
     */
    public function findAllCondition()
    {
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_CONDITION, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 解散交谈
     * @param $conversation_id
     * @return array
     * @throws OptionsException
     */
    public function deleteConversation($conversation_id = '')
    {
        if (empty($conversation_id)) {
            throw new OptionsException('交谈Id必填');
        }
        $response = $this->request('DELETE', $this->getBaseUrl() . self::CALLCENTER_CONVERSATION . "/" . $conversation_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 设置呼叫听说模式
     * @param $conversation_id
     * @param $agent_name
     * @param int $mode
     * @return array
     * @throws OptionsException
     */
    public function setConversationMode($conversation_id = '', $agent_name = '', $mode = 1)
    {
        if (empty($conversation_id)) {
            throw new OptionsException('交谈Id必填');
        }
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        $data = array(
            'mode' => $mode
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CONVERSATION . "/" . $conversation_id . "/agent/" . $agent_name . "/lsm", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 邀请坐席加入
     * @param $conversation_id
     * @param $enqueue
     * @param int $mode
     * @return array
     * @throws OptionsException
     */
    public function setConversationInviteAgent($conversation_id = '', $enqueue, $mode = 1)
    {
        if (empty($conversation_id)) {
            throw new OptionsException('交谈Id必填');
        }
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        // {BASE_URL}/callcenter/conversation/{conversation_id}/invite_agent
        $data = array(
            'enqueue' => $enqueue,
            'mode' => $mode
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CONVERSATION . "/" . $conversation_id . "/invite_agent", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 邀请外线加入
     * @param string $conversation_id
     * @param string $to
     * @param string $max_answer_seconds
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function setConversationInviteOut($conversation_id = '', $to = '', $max_answer_seconds = '', $options = array())
    {
        if (empty($conversation_id)) {
            throw new OptionsException('交谈Id必填');
        }
        if (empty($to)) {
            throw new OptionsException('外线号码必填');
        }
        if (empty($max_answer_seconds)) {
            throw new OptionsException('最长通话时间必填');
        }
        $conversation = ConversationOptions::out();
        $options = array_merge($conversation->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'to' => $to,
            'from' => $options['from'],
            'max_dial_seconds' => $options['max_dial_seconds'],
            'max_answer_seconds' => $max_answer_seconds,
            'mode' => $options['mode']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CONVERSATION . "/" . $conversation_id . "/invite_out", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取交谈单条记录
     * @param $conversation_id
     * @return array
     * @throws OptionsException
     */
    public function findConversation($conversation_id)
    {
        if (empty($conversation_id)) {
            throw new OptionsException('交谈Id必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_CONVERSATION . "/" . $conversation_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取交谈列表
     * @return array
     * @throws OptionsException
     */
    public function findAllConversation()
    {

        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_CONVERSATION, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 坐席拒绝排队任务
     * @param string $agent_name
     * @param string $queue_id
     * @param string $options
     * @return array
     * @throws OptionsException
     */
    public function setAgentRejectTask($agent_name = '', $queue_id = '', $options = '')
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if (empty($queue_id)) {
            throw new OptionsException('排队任务Id必填');
        }
        $data = array(
            'data' => $options
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }


    /**
     * 坐席呼叫外线
     * @param string $agent_name
     * @param string $to
     * @param string $max_answer_seconds
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function setAgentCallOut($agent_name = '', $to = '', $max_answer_seconds = '', $options = array())
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if (empty($to)) {
            throw new OptionsException('外线号码必填');
        }
        if (empty($max_answer_seconds)) {
            throw new OptionsException('最长通话时间必填');
        }
        $agent = AgentOptions::out();
        $options = array_merge($agent->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'to' => $to,
            'from' => $options['from'],
            'max_dial_seconds' => $options['max_dial_seconds'],
            'max_answer_seconds' => $max_answer_seconds,
            'mode' => $options['mode'],
            'user_data'=>$options['user_data']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/call_out", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 呼叫其它坐席
     * @param string $agent_name
     * @param string $enqueue
     * @return array
     * @throws OptionsException
     */
    public function setAgentCallAgent($agent_name = '', $enqueue = '')
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if (empty($enqueue)) {
            throw new OptionsException('目标坐席选择条件');
        }
        $data = array(
            'enqueue' => $enqueue
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/call_agent", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 前转到其它坐席
     * @param string $agent_name
     * @param string $queue_task_id
     * @param string $enqueue
     * @return array
     * @throws OptionsException
     */
    public function setAgentFwdAgent($agent_name = '', $queue_task_id = '', $enqueue = '')
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($queue_task_id)){
            throw new OptionsException('');
        }
        if (empty($enqueue)) {
            throw new OptionsException('目标坐席选择条件');
        }
        $data = array(
            'queue_task_id' => $queue_task_id,
            'enqueue' =>$enqueue
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/fwd_agent", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 后转到其它坐席
     * @param string $agent_name
     * @param string $conversation_id
     * @param string $enqueue
     * @return array
     * @throws OptionsException
     */
    public function setAgentXferAgent($agent_name = '', $conversation_id = '', $enqueue = '')
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($conversation_id)){
            throw new OptionsException('');
        }
        if (empty($enqueue)) {
            throw new OptionsException('目标坐席选择条件');
        }
        $data = array(
            'conversation_id' => $conversation_id,
            'enqueue' =>$enqueue
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/xfer_agent", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 后转到外线
     * @param string $agent_name
     * @param string $conversation_id
     * @param string $to
     * @param string $max_answer_seconds
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function setAgentXferOut($agent_name = '', $conversation_id = '', $to = '', $max_answer_seconds = '', $options= array())
    {
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($conversation_id)){
            throw new OptionsException('交谈Id必填');
        }
        if (empty($to)) {
            throw new OptionsException('外线号码必填');
        }
        if (empty($max_answer_seconds)) {
            throw new OptionsException('最长通话时间必填');
        }
        $agent = AgentOptions::out();
        $options = array_merge($agent->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'conversation_id' =>$conversation_id,
            'to' => $to,
            'from' => $options['from'],
            'max_dial_seconds' => $options['max_dial_seconds'],
            'max_answer_seconds' => $max_answer_seconds,
            'mode' => $options['mode']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/xfer_out", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 设置坐席听说模式
     * @param string $agent_name
     * @param string $conversation_id
     * @param int $mode
     * @return array
     * @throws OptionsException
     */
    public function setAgentMode($agent_name = '',$conversation_id = '',$mode = 1){
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($conversation_id)){
            throw new OptionsException('交谈Id必填');
        }
        $data = array(
            'conversation_id' =>$conversation_id,
            'mode' =>$mode
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/lsm", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 坐席加入交谈
     * @param string $agent_name
     * @param string $conversation_id
     * @param int $mode
     * @return array
     * @throws OptionsException
     */
    public function setAgentEnter($agent_name = '',$conversation_id = '',$mode = 1,$holding = true){
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($conversation_id)){
            throw new OptionsException('交谈Id必填');
        }
        $data = array(
            'conversation_id' =>$conversation_id,
            'mode' =>$mode,
            'holding' =>$holding
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/enter", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 坐席退出交谈
     * @param string $agent_name
     * @param string $conversation_id
     * @return array
     * @throws OptionsException
     */
    public function setAgentOut($agent_name = '',$conversation_id = ''){
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($conversation_id)){
            throw new OptionsException('交谈Id必填');
        }
        $data = array(
            'conversation_id' =>$conversation_id
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/exit", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 坐席合并交谈
     * @param string $agent_name
     * @param string $src_conversation_id
     * @param string $dst_conversation_id
     * @param int $mode
     * @return array
     * @throws OptionsException
     */
    public function setAgentMerge($agent_name = '',$src_conversation_id = '',$dst_conversation_id = '',$mode = 1){
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        if(empty($src_conversation_id)){
            throw new OptionsException('被合并的源头交谈必填');
        }
        if(empty($dst_conversation_id)){
            throw new OptionsException('被合并的目标交谈');
        }
        $data = array(
            'src_conversation_id' => $src_conversation_id,
            'dst_conversation_id' => $dst_conversation_id,
            'mode' => $mode
        );
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/merge", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取坐席所在交谈列表
     * @param string $agent_name
     * @return array
     * @throws OptionsException
     */
    public function findAgentConversation($agent_name = ''){
        if (empty($agent_name)) {
            throw new OptionsException('坐席名称必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_AGENT . "/" . $agent_name . "/conversation", array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }
}
