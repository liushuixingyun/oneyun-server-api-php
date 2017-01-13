<?php
namespace Oneyun\Rest\Api\CallCenter;

use Oneyun\Common\Options;
use Oneyun\Common\Values;

abstract class ExtensionOptions
{
    /**
     * @param int $type
     * @param null $user
     * @param null $password
     * @param null $ipaddr
     * @param null $telnum
     * @return CreateExtensionOptions
     */
    public static function create($type = 1, $user = null, $password = null, $ipaddr = null, $telnum = null)
    {
        return new CreateExtensionOptions($type, $user, $password, $ipaddr, $telnum);
    }

}


class CreateExtensionOptions extends Options
{

    public function __construct($type = Values::NONE, $user = Values::NONE, $password = Values::NONE, $ipaddr = Values::NONE, $telnum = Values::NONE)
    {
        $this->options['type'] = $type;
        $this->options['user'] = $user;
        $this->options['password'] = $password;
        $this->options['ipaddr'] = $ipaddr;
        $this->options['telnum'] = $telnum;
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
        return '[Oneyun.Api.CreateExtensionOptions ' . implode(' ', $options) . ']';
    }

}