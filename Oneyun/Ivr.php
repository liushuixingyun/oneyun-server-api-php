<?php

namespace Oneyun;

class Ivr
{
    /**
     * @var \SimpleXMLElement
     */
    protected $element;

    /**
     * 节点名
     * @var
     */
    protected $_verb;
    /**
     * 节点值
     * @var
     */
    protected $_noun;

    /**
     * 参数
     * @var
     */
    protected $_attrs;

    /**
     * play node
     * @var array
     */
    protected static $playAttr = array('finish_keys', 'repeat');

    /**
     * record node
     * @var array
     */
    protected static $recordAttr = array('max_duration', 'beeping', 'finish_keys');

    /**
     * @var array
     */
    protected static $dailAttr = array('from', 'max_call_duration', 'max_dial_duration', 'dial_voice_stop_cond');

    /**
     * @var array
     */
    protected static $getAttr = array('valid_keys', 'max_keys', 'finish_keys', 'first_key_timeout', 'continues_keys_timeout', 'play_repeat', 'if_break_on_key');

    /**
     * @var array
     */
    protected static $connectAttr = array('max_duration', 'mode', 'recording', 'volume1', 'volume2', 'play_time');

    /**
     * @var array
     */
    protected static $pauseAttr = array('timeout');

    /**
     * @var array
     */
    protected static $node = array('play', 'record', 'send_dtmf', 'get', 'hangup', 'dial', 'connect', 'next', 'playlist', 'pause');

    /**
     *  初始化
     * Ivr constructor.
     * @param null $arg
     */
    public function __construct($arg = null)
    {
        switch (true) {
            case $arg instanceof \SimpleXMLElement:
                $this->element = $arg;
                break;
            case $arg === null:
                $this->element = new \SimpleXMLElement('<response/>');
                break;
            case is_array($arg):
                $this->element = new \SimpleXMLElement('<response/>');
                foreach ($arg as $name => $value) {
                    $this->element->addAttribute($name, $value);
                }
                break;
            default:
                throw new \Exceptions('Invalid argument');
        }
    }

    /**
     * @param $verb
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($verb, array $args)
    {

        list($noun, $attrs) = $args + array('', array());

        $this->_verb = $verb;
        $this->_noun = $noun;
        $this->_attrs = $attrs;

        if (!in_array($verb, self::$node)) {
            throw new \Exception('Method does not exist');
        }

        $method = 'create' . ucfirst($verb);

        if (!function_exists($method)) {
            return $this->$method();
        }
    }


    /**
     * 创建play 放音节点
     * @return static
     */
    private function createPlay()
    {
        $this->Filter(self::$playAttr);
        return new static($this->addChild());
    }

    /**
     * 创建playlist 放音节点
     * @return static
     */
    private function createPlaylist()
    {
        $this->Filter(self::$playAttr);

        $child = $this->addAttribute($this->element->addChild($this->_verb, " "));

        if (is_array($this->_noun)) {
            foreach ($this->_noun as $value) {
                $child->addChild('play', $value);
            }
        } else {
            $child->addChild('play', $this->_noun);
        }

        return new static($child);
    }

    /**
     * 创建pause 暂停节点
     */
    protected function createPause()
    {
        $attr = $this->_noun;

        if (!is_array($attr) && !empty($attr)) {
            throw new \Exception('The first parameter is an array, refer to the SDK Pause Record function');
        }

        $this->Filter(self::$pauseAttr, $attr);

        $child = $this->addAttribute($this->element->addChild($this->_verb, " "));

        return new static($child);
    }

    /**
     * 创建next 后续节点
     * @return static
     */
    protected function createNext()
    {
        return new static($this->addChild());
    }

    /**
     * 创建record 录音节点
     * @return static
     */
    protected function createRecord()
    {
        $attr = $this->_noun;

        if (!is_array($attr) && !empty($attr)) {
            throw new \Exception('The first parameter is an array, refer to the SDK IVR Record function');
        }

        $this->Filter(self::$recordAttr, $attr);

        $child = $this->addAttribute($this->element->addChild($this->_verb, " "));

        return new static($child);
    }

    /**
     * 创建send_dtmf 发码节点
     * @return static
     */
    protected function createSend_dtmf()
    {
        return new static($this->addChild());
    }

    /**
     * 创建get 收码节点
     * @return static
     */
    protected function createGet()
    {
        //过滤参数
        $this->Filter(self::$getAttr);

        $child = $this->addAttribute($this->element->addChild($this->_verb, " "));

        if (is_array($this->_noun)) {

            $child = $child->addChild('playlist', " ");

            foreach ($this->_noun as $value) {
                $child->addChild('play', $value);
            }

        } else if ($this->_noun) {

            $child->addChild('play', $this->_noun);

        }

        return $child;
    }

    /**
     * 创建hangup 挂断节点
     * @return static
     */
    protected function createHangup()
    {
        return new static($this->addChild());
    }

    /**
     * 创建dail 拨号节点
     * @return static
     */
    protected function createDial()
    {
        $params = $this->_attrs;

        ///过滤参数
        $this->Filter(self::$dailAttr);

        $child = $this->addAttribute($this->element->addChild($this->_verb));

        //<number>
        if ($this->_noun) {
            $child->addChild('number', $this->_noun);
        }
        //<connect>
        if (array_key_exists('connect', $params)) {

            $this->Filter(self::$connectAttr, $params['connect']);
            $child = $this->addAttribute($child->addChild('connect', " "));

            //<play>
            $play = isset($params['connect']['play']) ? $params['connect']['play'] : '';
            if ($play) {
                $noun = isset($play[0]) ? $play[0] : '';
                $playAttr = isset($play[1]) ? $play[1] : array();
                $this->Filter(self::$playAttr, $playAttr);
                $play = $child->addChild('play', $noun);
                $this->addAttribute($play, $playAttr);
            }
        } else {
            $child->addChild('connect');
        }
        return new static($child);
    }

    /**
     * 创建connect 连接节点
     */
    protected function createConnect()
    {

        //过滤参数
        $this->Filter(self::$recordAttr);

        $child = $this->addAttribute($this->element->addChild($this->_verb, " "));

        if (is_array($this->_noun)) {

            $child = $child->addChild('playlist', " ");

            foreach ($this->_noun as $value) {
                $child->addChild('play', $value);
            }

        } else if ($this->_noun) {

            $child->addChild('play', $this->_noun);

        }

        return $child;
    }

    /**
     * 过滤出有效属性
     *
     * @param $type
     * @return string
     */
    protected function Filter($type = array(), $attrs = array())
    {
        $params = array();
        $attrs = !empty($attrs) ? $attrs : $this->_attrs;

        if ($attrs) {
            $keys = array_keys($attrs);
            $valid = array_intersect($keys, $type);
            if ($valid) {
                foreach ($valid as $v)
                    $params[$v] = $attrs[$v];
            }
        }
        $this->_attrs = $params;
    }


    /**
     * 添加子节点
     * @return \SimpleXMLElement
     */
    protected function addChild()
    {

        $decoded = html_entity_decode($this->_noun, ENT_COMPAT, 'UTF-8');

        $normalized = htmlspecialchars($decoded, ENT_COMPAT, 'UTF-8', false);

        $hasNoun = is_scalar($this->_noun) && strlen($this->_noun);

        $child = $hasNoun ? $this->element->addChild($this->_verb, $normalized) : $this->element->addChild($this->_verb, " ");

        return $this->addAttribute($child);
    }

    /**
     * 添加节点参数值
     * @return \SimpleXMLElement
     */
    protected function addAttribute($child)
    {
        if (is_array($this->_attrs)) {
            foreach ($this->_attrs as $name => $value) {
                if (is_bool($value)) {
                    $value = ($value === true) ? 'true' : 'false';
                }
                $child->addAttribute($name, $value);
            }
        }
        return $child;
    }

    /**
     *  直接输出时显示
     * @return string
     */
    public function __toString()
    {
        $xml = $this->element->asXML();
        $xml = str_replace("> <", "><", $xml);

        return (string)str_replace(
            '<?xml version="1.0"?>',
            '<?xml version="1.0" encoding="UTF-8"?>', $xml);
    }
}
