<?php
namespace Oneyun\Rest\Api;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class MettingOptions
{
    /**
     * @param null $max_duration defualt null
     * @param string $max_parts
     * @param null $recording defualt null
     * @param string $auto_hangup
     * @param null $bgm_file defualt null
     * @param string $user_data
     * @return CreateCallOptions
     */
    public static function create($max_duration = Values::NONE, $max_parts = Values::NONE, $recording = Values::NONE, $auto_hangup = Values::NONE, $bgm_file = Values::NONE, $user_data = null)
    {
        return new CreateCallOptions($max_duration, $max_parts, $recording, $auto_hangup, $bgm_file,$user_data);
    }

}


class CreateConfOptions extends Options
{

    public function __construct($max_duration = Values::NONE, $max_parts = Values::NONE, $recording = Values::NONE,$auto_hangup = Values::NONE, $bgm_file = Values::NONE, $user_data = Values::NONE)
    {
        $this->options['max_duration'] = $max_duration;
        $this->options['max_parts'] = $max_parts;
        $this->options['recording'] = $recording;
        $this->options['auto_hangup'] = $auto_hangup;
        $this->options['bgm_file'] = $bgm_file;
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
        return '[Oneyun.Api.CreateCallOptions ' . implode(' ', $options) . ']';
    }

}