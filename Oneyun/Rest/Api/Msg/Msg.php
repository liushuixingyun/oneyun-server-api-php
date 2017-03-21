<?php
namespace Oneyun\Rest\Api\Msg;

use Oneyun\Exceptions\OptionsException;
use Oneyun\Version;
use Oneyun\Domain;
use Oneyun\Common\Values;

class Msg extends Version
{
    const MSG_TEMPLATE = "msg/template"; // 模板管理
    const MSG_USSD = "msg/ussd"; // 闪印
    const MSG_SMS = "msg/sms"; // 短信

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }


    /**
     * 创建模板
     * @param $name
     * @param $content
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function createTemplate($name, $content, $options)
    {
        if (!$name) {
            throw new OptionsException('请填写模板名称');
        }
        if (!$name) {
            throw new OptionsException('请填写模板内容');
        }
        $template = TemplateOptions::create();
        $options = array_merge($template->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'name' => $name,
            'type' => $options['type'],
            'content' => $content,
            'remark' => $options['remark']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MSG_TEMPLATE, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 修改模板
     * @param $templateId
     * @param $name
     * @param $content
     * @param $options
     * @return array
     * @throws OptionsException
     */
    public function editTemplate($templateId, $name, $content, $options)
    {
        if (!$templateId) {
            throw new OptionsException('请填写模板Id');
        }
        if (!$name) {
            throw new OptionsException('请填写模板名称');
        }
        if (!$content) {
            throw new OptionsException('请填写模板内容');
        }
        $template = TemplateOptions::create();
        $options = array_merge($template->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'name' => $name,
            'type' => $options['type'],
            'content' => $content,
            'remark' => $options['remark']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MSG_TEMPLATE . "/" . $templateId, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 删除模板
     * @param $templateId
     * @return array
     * @throws OptionsException
     */
    public function deleteTemplate($templateId)
    {
        if (!$templateId) {
            throw new OptionsException('请填写模板Id');
        }
        $response = $this->request('DELETE', $this->getBaseUrl() . self::MSG_TEMPLATE . "/" . $templateId, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 查询模板
     * @param $templateId
     * @return array
     * @throws OptionsException
     */
    public function findTemplate($templateId)
    {
        if (!$templateId) {
            throw new OptionsException('请填写模板Id');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::MSG_TEMPLATE . "/" . $templateId, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 查询模板列表
     * @param int $pageNo
     * @param int $pageSize
     * @return array
     */
    public function findAllTemplate($pageNo = 1, $pageSize = 20)
    {
        $data = array(
            'pageNo' => $pageNo,
            'pageSize' => $pageSize
        );
        $response = $this->request('GET', $this->getBaseUrl() . self::MSG_TEMPLATE, $data, array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 发送闪印
     * @param $mobile
     * @param $tempId
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function createUssd($mobile, $tempId, $options = array())
    {
        if (!$mobile) {
            throw new OptionsException('目标号码（必须为移动号码）');
        }
        if (!$tempId) {
            throw new OptionsException('模板编号必填');
        }
        $ussd = UssdOptions::createSingle();
        $options = array_merge($ussd->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'mobile' => $mobile,
            'tempId' => $tempId,
            'tempArgs' => $options['tempArgs']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MSG_USSD . "/send", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }


    /**
     * @param null $taskName
     * @param null $tempId
     * @param null $mobiles
     * @param null $sendTime
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function createUssdTask($taskName = null, $tempId = null, $mobiles = null, $sendTime = null, $options = array())
    {
        if (!$taskName) {
            throw new OptionsException('目标号码（必须为移动号码）');
        }
        if (!$tempId) {
            throw new OptionsException('模板编号必填');
        }
        if (!$mobiles) {
            throw new OptionsException('发送号码必填');
        }
        if (!$sendTime) {
            throw new OptionsException('发送时间必填');
        }
        $ussd = UssdOptions::createMass();
        $options = array_merge($ussd->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'taskName' => $taskName,
            'tempId' => $tempId,
            'tempArgs' => $options['tempArgs'],
            'mobiles' => $mobiles,
            'sendTime' => $sendTime,
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MSG_USSD . "/mass/task", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 闪印发送结果查询
     * @param $msgKey
     * @return array
     * @throws OptionsException
     */
    public function findUssd($msgKey)
    {
        if (!$msgKey) {
            throw new OptionsException('消息任务标识必填');
        }
        $response = $this->request('GET ', $this->getBaseUrl() . self::MSG_USSD . "/" . $msgKey, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 发送短信
     * @param $mobile
     * @param $tempId
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function createSms($mobile = null, $tempId = null, $options = array())
    {
        if (!$mobile) {
            throw new OptionsException('目标号码（必须为移动号码）');
        }
        if (!$tempId) {
            throw new OptionsException('模板编号必填');
        }
        $sms = SmsOptions::createSingle();
        $options = array_merge($sms->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'mobile' => $mobile,
            'tempId' => $tempId,
            'tempArgs' => $options['tempArgs']
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MSG_SMS . "/send", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }


    /**
     * 发送群发模板短信任务
     * @param null $taskName
     * @param null $tempId
     * @param null $mobiles
     * @param null $sendTime
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function createSmsTask($taskName = null, $tempId = null, $mobiles = null, $sendTime = null, $options = array())
    {
        if (!$taskName) {
            throw new OptionsException('群发任务名称必填');
        }
        if (!$tempId) {
            throw new OptionsException('模板编号必填');
        }
        if (!$mobiles) {
            throw new OptionsException('发送号码必填');
        }
        if (!$sendTime) {
            throw new OptionsException('发送时间必填');
        }
        $sms = SmsOptions::createMass();
        $options = array_merge($sms->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'taskName' => $taskName,
            'tempId' => $tempId,
            'tempArgs' => $options['tempArgs'],
            'mobiles' => $mobiles,
            'sendTime' => $sendTime,
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MSG_SMS . "/mass/task", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 短信发送结果查询
     * @param $msgKey
     * @return array
     * @throws OptionsException
     */
    public function findSms($msgKey)
    {
        if (!$msgKey) {
            throw new OptionsException('消息任务标识必填');
        }
        $response = $this->request('GET', $this->getBaseUrl() . self::MSG_SMS . "/" . $msgKey, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }


}
