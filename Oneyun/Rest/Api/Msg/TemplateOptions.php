<?php
namespace Oneyun\Rest\Api\Msg;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class TemplateOptions
{

    public static function create($name = null, $type = 'msg_sms', $content = null, $remark = null)
    {
        return new CreateTemplateOptions($name, $type, $content, $remark);
    }
}

class CreateTemplateOptions extends Options
{
    public function __construct($name = Values::NONE, $type = Values::NONE, $content = Values::NONE, $remark = Values::NONE)
    {
        $this->options['name'] = $name;
        $this->options['type'] = $type;
        $this->options['content'] = $content;
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
        return '[Oneyun.Api.CreateTemplateOptions ' . implode(' ', $options) . ']';
    }

}

