<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class AgentOptions
{
    /**
     * @param null $type defualt null
     * @param string $user
     * @param null $password null
     * @param string $ipaddr
     * @param null $telnum defualt null
     * @return CreateCallOptions
     */
    public static function create($name = null, $channel = null, $num = null, $state = null, $skills = null,$extension = null)
    {
        return new CreateAgentOptions($name, $channel, $num, $state, $skills,$extension);
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