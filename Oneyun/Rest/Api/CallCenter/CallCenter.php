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
    const CALLCENTER_CHANNEL = "callcenter/channel"; //通道
    const CALLCENTER_CONDITION = "callcenter/condition"; //排队

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
     * @param null $channel
     * @param $extension
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function agentLogin($name, $channel, $extension, $options)
    {
        if (empty($name)) {
            throw new OptionsException('登录必填');
        }
        if (empty($channel)) {
            throw new OptionsException('通道必填');
        }
        if (empty($extension)) {
            throw new OptionsException('坐席的分机必填');
        }
        $agent = AgentOptions::create();
        $options = array_merge($agent->getOptions(), $options);
        $options = new Values($options);

        $data = Values::of(array(
            'name' => $name,
            'channel' => $channel,
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
    public function findAllAgent($pageNo, $pageSize)
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
     * 新建通道
     * @param $max_agent
     * @param $max_skill
     * @param $max_condition
     * @param $max_queue
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function createChannel($max_agent, $max_skill, $max_condition, $max_queue, $options)
    {
        if (empty($max_agent)) {
            throw new OptionsException('工作通道所容纳的最大坐席数量必填');
        }
        if (empty($max_skill)) {
            throw new OptionsException('工作通道所容纳的最大技能数量必填');
        }
        if (empty($max_condition)) {
            throw new OptionsException('工作通道所容纳的最大排队条件设置数量必填');
        }
        if (empty($max_queue)) {
            throw new OptionsException('工作通道所容纳的最大排队任务数量必填');
        }
        $channel = ChannelOptions::create();
        $options = array_merge($channel->getOptions(), $options);
        $options = new Values($options);

        $data = Values::of(array(
            'max_agent' => $max_agent,
            'max_skill' => $max_skill,
            'max_condition' => $max_condition,
            'max_queue' => $max_queue,
            'remark' => $options['remark']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CHANNEL, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 删除通道
     * @param $channel_id
     * @return array
     * @throws OptionsException
     */
    public function deleteChannel($channel_id)
    {
        if (empty($channel_id)) {
            throw new OptionsException('通道Id必填');
        }
        $response = $this->request('DELETE', $this->getBaseUrl() . self::CALLCENTER_CHANNEL . "/" . $channel_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 修改通道
     * @param $max_agent
     * @param $max_skill
     * @param $max_condition
     * @param $max_queue
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function editChannel($channel_id, $max_agent, $max_skill, $max_condition, $max_queue, $options)
    {
        if (empty($channel_id)) {
            throw new OptionsException('通道Id必填');
        }
        if (empty($max_agent)) {
            throw new OptionsException('工作通道所容纳的最大坐席数量必填');
        }
        if (empty($max_skill)) {
            throw new OptionsException('工作通道所容纳的最大技能数量必填');
        }
        if (empty($max_condition)) {
            throw new OptionsException('工作通道所容纳的最大排队条件设置数量必填');
        }
        if (empty($max_queue)) {
            throw new OptionsException('工作通道所容纳的最大排队任务数量必填');
        }
        $channel = ChannelOptions::create();
        $options = array_merge($channel->getOptions(), $options);
        $options = new Values($options);

        $data = Values::of(array(
            'max_agent' => $max_agent,
            'max_skill' => $max_skill,
            'max_condition' => $max_condition,
            'max_queue' => $max_queue,
            'remark' => $options['remark']
        ));


        $response = $this->request('POST', $this->getBaseUrl() . self::CALLCENTER_CHANNEL . "/" . $channel_id, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取单条通道记录
     * @param $channel_id
     * @return array
     * @throws OptionsException
     */
    public function findChannel($channel_id)
    {
        if (empty($channel_id)) {
            throw new OptionsException('通道Id必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_CHANNEL . "/" . $channel_id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 获取多条通道记录
     * @return array
     */
    public function findAllChannel()
    {
        $response = $this->request('GET', $this->getBaseUrl() . self::CALLCENTER_CHANNEL, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 新建排队条件
     * @param $channe
     * @param $where
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function createCondition($channe, $where, $options = array())
    {
        if (empty($channe)) {
            throw new OptionsException('通道Id必填');
        }
        if (empty($where)) {
            throw new OptionsException('条件表达式必填');
        }

        $channel = ConditionOptions::create();
        $options = array_merge($channel->getOptions(), $options);
        $options = new Values($options);

        $data = Values::of(array(
            'channel' => $channe,
            'where' => $where,
            'sort' => $options['sort'],
            'priority' => $options['priority'],
            'queue_timeout' => $options['queue_timeout'],
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
     * @param $channe
     * @param $where
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function editCondition($condition_id, $channe, $where, $options)
    {
        if (empty($condition_id)) {
            throw new OptionsException('条件Id必填');
        }
        if (empty($channe)) {
            throw new OptionsException('通道Id必填');
        }
        if (empty($where)) {
            throw new OptionsException('条件表达式必填');
        }
        $channel = ConditionOptions::create();
        $options = array_merge($channel->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'channel' => $channe,
            'where' => $where,
            'sort' => $options['sort'],
            'priority' => $options['priority'],
            'queue_timeout' => $options['queue_timeout'],
            'fetch_timeout' => $options['fetch_timeout'],
            'remark' => $options['remark']
        ));
        $response = $this->request('DELETE', $this->getBaseUrl() . self::CALLCENTER_CONDITION . "/" . $condition_id, array(), $data);
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


}
