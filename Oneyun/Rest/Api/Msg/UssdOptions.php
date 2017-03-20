<?php
namespace Oneyun\Rest\Api\Msg;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class UssdOptions
{

    public static function createSingle($destPhone = null, $tempId = null, $tempArgs = null)
    {
        return new CreateUssdOptions($destPhone, $tempId, $tempArgs);
    }

    public static function createMass($taskName = null, $tempId = null, $tempArgs = null, $mobiles = null, $sendTime = null)
    {
        return new CreateUssdMassOptions($taskName, $tempId, $tempArgs, $mobiles, $sendTime);
    }
}

class CreateUssdOptions extends Options
{
    public function __construct($destPhone = Values::NONE, $tempId = Values::NONE, $tempArgs = Values::NONE)
    {
        $this->options['destPhone'] = $destPhone;
        $this->options['tempId'] = $tempId;
        $this->options['tempArgs'] = $tempArgs;
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
        return '[Oneyun.Api.CreateUssdOptions ' . implode(' ', $options) . ']';
    }

}

class CreateUssdMassOptions extends Options
{
    public function __construct($taskName = Values::NONE, $tempId = Values::NONE, $tempArgs = Values::NONE, $mobiles = Values::NONE, $sendTime = Values::NONE)
    {
        $this->options['taskName'] = $taskName;
        $this->options['tempId'] = $tempId;
        $this->options['tempArgs'] = $tempArgs;
        $this->options['mobiles'] = $mobiles;
        $this->options['sendTime'] = $sendTime;
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
        return '[Oneyun.Api.CreateUssdOptions ' . implode(' ', $options) . ']';
    }

}
