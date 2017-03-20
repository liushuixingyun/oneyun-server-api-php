<?php
namespace Oneyun\Rest\Api\Management;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class TelNumOptions
{
    /**
     * @param null $callbackUrl
     * @param null $remark
     * @param array $quotas
     * @return CreateSubAccountOptions
     */
    public static function create($callbackUrl = null, $remark = null, $quotas = array())
    {
        return new CreateSubAccountOptions($callbackUrl, $remark, $quotas);
    }
}

class CreateSubAccountOptions extends Options
{
    public function __construct($callbackUrl = Values::NONE, $remark = Values::NONE, $quotas = Values::NONE)
    {
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['remark'] = $remark;
        $this->options['quotas'] = $quotas;
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
        return '[Oneyun.Api.CreateSubAccountOptions ' . implode(' ', $options) . ']';
    }

}

