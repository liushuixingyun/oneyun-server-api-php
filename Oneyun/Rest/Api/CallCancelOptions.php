<?php
namespace Oneyun\Rest\Api;

use Oneyun\Options;
use Oneyun\Values;

abstract class CallOptions
{

    public static function create($from1 = null, $to1 = Values::NONE, $from2 = null, $to2 = Values::NONE, $ring_tone = null, $ring_tone_mode = 0, $max_dial_duration = 60, $max_call_duration = 3600, $recording = 0, $record_mode = 0, $user_data = '')
    {
        return new CreateCallOptions($from1, $to1, $from2, $to2, $ring_tone, $ring_tone_mode, $max_dial_duration, $max_call_duration, $recording, $record_mode, $user_data);
    }

}


class CreateCallOptions extends Options
{

    public function __construct($from1 = Values::NONE, $to1 = Values::NONE, $from2 = Values::NONE, $to2 = Values::NONE, $ring_tone = Values::NONE, $ring_tone_mode = Values::NONE, $max_dial_duration = Values::NONE, $max_call_duration = Values::NONE, $recording = Values::NONE, $record_mode = Values::NONE, $user_data = Values::NONE)
    {
        $this->options['from1'] = $from1;
        $this->options['to1'] = $to1;
        $this->options['from2'] = $from2;
        $this->options['to2'] = $to2;
        $this->options['ring_tone'] = $ring_tone;
        $this->options['ring_tone_mode'] = $ring_tone_mode;
        $this->options['max_dial_duration'] = $max_dial_duration;
        $this->options['max_call_duration'] = $max_call_duration;
        $this->options['recording'] = $recording;
        $this->options['record_mode'] = $record_mode;
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