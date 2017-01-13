<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class ConditionOptions
{
    /**
     * @param null $channel
     * @param null $where
     * @param null $sort
     * @param int $priority
     * @param null $queue_timeout
     * @param null $fetch_timeout
     * @param null $remark
     * @return CreateConditionOptions
     */
    public static function create($channel = null, $where = null, $sort = null, $priority = 0, $queue_timeout = null, $fetch_timeout = null,$remark = null)
    {
        return new CreateConditionOptions($channel, $where, $sort, $priority, $queue_timeout = null, $fetch_timeout = null,$remark);
    }
}


class CreateConditionOptions extends Options
{
    public function __construct($channel = Values::NONE, $where = Values::NONE, $sort = Values::NONE, $priority = Values::NONE, $queue_timeout = Values::NONE,$fetch_timeout = Values::NONE,$remark = Values::NONE)
    {
        $this->options['max_agent'] = $channel;
        $this->options['max_skill'] = $where;
        $this->options['max_condition'] = $sort;
        $this->options['priority'] = $priority;
        $this->options['queue_timeout'] = $queue_timeout;
        $this->options['fetch_timeout'] = $fetch_timeout;
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