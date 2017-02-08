<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class ConversationOptions
{
    public static function out($from = null, $max_dial_seconds = null, $mode = 4)
    {
        return new InviteOutConversationOptions($from, $max_dial_seconds);
    }
}

class InviteOutConversationOptions extends Options
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
        return '[Oneyun.Api.InviteOutConversationOptions ' . implode(' ', $options) . ']';
    }

}