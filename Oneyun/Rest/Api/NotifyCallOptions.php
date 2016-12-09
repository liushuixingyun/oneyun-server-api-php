<?php
namespace Oneyun\Rest\Api;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class NotifyCallOptions
{
    /**
     * @param null $from defualt null
     * @param string $to
     * @param int $repeat  defualt 0
     * @param int $max_dial_duration defualt 45
     * @param null $play_file
     * @param null $play_content
     * @param string $user_data defualt ''
     * @return CreateNotifyCallOptions
     */
    public static function create($from = null, $to = Values::NONE, $repeat = 0, $max_dial_duration = 45, $play_file = null, $play_content = null ,$user_data = '')
    {
        return new CreateNotifyCallOptions($from, $to, $repeat, $max_dial_duration, $play_file, $play_content, $user_data);
    }
}


class CreateNotifyCallOptions extends Options
{

    public function __construct($from = Values::NONE, $to = Values::NONE, $repeat = Values::NONE, $max_dial_duration = Values::NONE, $play_file = Values::NONE, $play_content = Values::NONE, $user_data = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['to'] = $to;
        $this->options['repeat'] = $repeat;
        $this->options['max_dial_duration'] = $max_dial_duration;
        $this->options['play_file'] = $play_file;
        $this->options['play_content'] = $play_content;
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
        return '[Oneyun.Api.CreateNotifyCallOptions ' . implode(' ', $options) . ']';
    }

}