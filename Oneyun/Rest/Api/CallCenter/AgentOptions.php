<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class AgentOptions
{
    /**
     * @param null $name
     * @param null $channel
     * @param null $num
     * @param null $state
     * @param array $skills
     * @param null $extension
     * @return CreateAgentOptions
     */
    public static function create($name = null, $channel = null, $num = null, $state = null, $skills = array(),$extension = null)
    {
        return new CreateAgentOptions($name, $channel, $num, $state, $skills,$extension);
    }

    public static function out($from = null, $max_dial_seconds = null, $mode = 4)
    {
        return new CallOutAgentOptions($from, $max_dial_seconds, $mode);
    }

}

class CreateAgentOptions extends Options
{
    public function __construct($name = Values::NONE, $channel = Values::NONE, $num = Values::NONE, $state = Values::NONE, $skills = Values::NONE, $extension = Values::NONE)
    {
        $this->options['name'] = $name;
        $this->options['channel'] = $channel;
        $this->options['num'] = $num;
        $this->options['state'] = $state;
        $this->options['skills'] = $skills;
        $this->options['extension'] = $extension;
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

class CallOutAgentOptions extends Options
{
    public function __construct($from = Values::NONE, $max_dial_seconds = Values::NONE, $mode = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['max_dial_seconds'] = $max_dial_seconds;
        $this->options['mode'] = $mode;
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
        return '[Oneyun.Api.CallOutAgentOptions ' . implode(' ', $options) . ']';
    }

}