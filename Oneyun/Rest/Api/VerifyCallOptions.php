<?php
namespace Oneyun\Rest\Api;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class VerifyCallOptions
{
    /**
     * @param null $from default null
     * @param string $to
     * @param int $repeat default 1
     * @param int $max_dial_duration default 50
     * @param null $play_file
     * @param null $verify_code
     * @param string $user_data
     * @return CreateVerifyCallOptions
     */
    public static function create($from = null, $to = Values::NONE, $repeat = 0, $max_dial_duration = 50, $play_file = null, $verify_code = null ,$user_data = '')
    {
        return new CreateVerifyCallOptions($from, $to, $repeat, $max_dial_duration, $play_file, $verify_code, $user_data);
    }
}


class CreateVerifyCallOptions extends Options
{

    public function __construct($from = Values::NONE, $to = Values::NONE, $repeat = Values::NONE, $max_dial_duration = Values::NONE, $play_file = Values::NONE, $verify_code = Values::NONE, $user_data = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['to'] = $to;
        $this->options['repeat'] = $repeat;
        $this->options['max_dial_duration'] = $max_dial_duration;
        $this->options['play_file'] = $play_file;
        $this->options['verify_code'] = $verify_code;
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
        return '[Oneyun.Api.CreateVerifyCallOptions ' . implode(' ', $options) . ']';
    }

}