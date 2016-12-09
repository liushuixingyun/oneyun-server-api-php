<?php
namespace Oneyun\Rest\Api;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class IvrCallOptions
{
    /**
     * @param null $from
     * @param string $to
     * @param int $repeat  default 0
     * @param int $max_dial_duration default 50
     * @param null $play_file
     * @param null $play_content
     * @param string $user_data deault ''
     * @return CreateNotifyCallOptions
     */
    public static function create($from = null, $to = Values::NONE, $max_dial_duration = 50, $max_call_duration = 360,$user_data = '')
    {
        return new CreateIvrCallOptions($from, $to, $max_dial_duration, $max_call_duration, $user_data);
    }
}


class CreateIvrCallOptions extends Options
{

    public function __construct($from = Values::NONE, $to = Values::NONE, $max_dial_duration = Values::NONE, $max_call_duration = Values::NONE, $user_data = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['to'] = $to;
        $this->options['max_dial_duration'] = $max_dial_duration;
        $this->options['max_call_duration'] = $max_call_duration;
        $this->options['user_data'] = $user_data;
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
        return '[Oneyun.Api.CreateIvrCallOptions ' . implode(' ', $options) . ']';
    }

}