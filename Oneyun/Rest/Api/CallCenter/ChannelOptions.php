<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class ChannelOptions
{
    /**
     * @param null $max_agent
     * @param null $max_skill
     * @param null $max_condition
     * @param null $max_queue
     * @param null $remark
     * @return CreateChannelOptions
     */
    public static function create($max_agent = null, $max_skill = null, $max_condition = null, $max_queue = null, $remark = null)
    {
        return new CreateChannelOptions($max_agent, $max_skill, $max_condition, $max_queue, $remark);
    }

}


class CreateChannelOptions extends Options
{
    public function __construct($max_agent = Values::NONE, $max_skill = Values::NONE, $max_condition = Values::NONE, $max_queue = Values::NONE, $remark = Values::NONE)
    {
        $this->options['max_agent'] = $max_agent;
        $this->options['max_skill'] = $max_skill;
        $this->options['max_condition'] = $max_condition;
        $this->options['max_queue'] = $max_queue;
        $this->options['remark'] = $remark;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString()
    {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Oneyun.Api.CreateAgentOptions ' . implode(' ', $options) . ']';
    }

}