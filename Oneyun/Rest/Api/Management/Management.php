<?php
namespace Oneyun\Rest\Api\Management;

use Oneyun\Exceptions\OptionsException;
use Oneyun\Version;
use Oneyun\Domain;
use Oneyun\Common\Values;

class Management extends Version
{
    const MANAGEMENT_SUBACCOUNT = "management/subaccount"; // 子帐号
    const MANAGEMENT_TELNUM = "management/telnum"; // 号码管理

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
    }

    /**
     * 创建子账号
     * @param array $options
     * @return array
     */
    public function createSubAccount($options = array())
    {
        $account = SubAccountOptions::create();
        $options = array_merge($account->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'callbackUrl' => $options['callbackUrl'],
            'remark' => $options['remark'],
            'quotas' => $options['quotas'],
        ));
        $response = $this->request('POST', $this->getBaseUrl() . self::MANAGEMENT_SUBACCOUNT, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 修改子账号
     * @param $id
     * @param array $options
     * @return array
     */
    public function editSubAccount($id, $options = array())
    {
        $account = SubAccountOptions::create();
        $options = array_merge($account->getOptions(), $options);
        $options = new Values($options);
        $data = Values::of(array(
            'callbackUrl' => $options['callbackUrl'],
            'remark' => $options['remark'],
            'quotas' => $options['quotas'],
        ));
        $response = $this->request('PUT', $this->getBaseUrl() . self::MANAGEMENT_SUBACCOUNT . "/" . $id, array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 删除子帐号
     * @param string $id
     * @return array
     * @throws OptionsException
     */
    public function deleteSubAccount($id = '')
    {
        if (!$id) {
            throw new OptionsException('请填写子帐号Id');
        }
        $response = $this->request('DELETE ', $this->getBaseUrl() . self::MANAGEMENT_SUBACCOUNT . "/" . $id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 查询子帐号列表
     * @param int $pageNo
     * @param int $pageSize
     * @return array
     */
    public function findAllSubAccount($pageNo = 1, $pageSize = 20)
    {
        $data = array(
            'pageNo' => $pageNo,
            'pageSize' => $pageSize
        );
        $response = $this->request('GET ', $this->getBaseUrl() . self::MANAGEMENT_SUBACCOUNT, $data, array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 子账号详情
     * @param string $id
     * @return array
     * @throws OptionsException
     */
    public function findSubAccount($id = '')
    {
        if (empty($id)) {
            throw new OptionsException('请填写子帐号Id');
        }
        $response = $this->request('GET ', $this->getBaseUrl() . self::MANAGEMENT_SUBACCOUNT . "/" . $id, array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 设置子账号配额
     * @param string $id
     * @param array $options
     * @return array
     * @throws OptionsException
     */
    public function setSubAccountQuotas($id = '', $options = array())
    {
        if (empty($id)) {
            throw new OptionsException('请填写子帐号Id');
        }
        $data = array(
            'quotas' => $options
        );
        $response = $this->request('PUT ', $this->getBaseUrl() . self::MANAGEMENT_SUBACCOUNT . "/" . $id . "/quotas", array(), $data);
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 查询号码列表
     * @param int $pageNo
     * @param int $pageSize
     * @return array
     */
    public function findAllTelNum($pageNo = 1, $pageSize = 20)
    {
        $data = array(
            'pageNo' => $pageNo,
            'pageSize' => $pageSize
        );
        $response = $this->request('GET ', $this->getBaseUrl() . self::MANAGEMENT_TELNUM, $data, array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }


    /**
     * 号码绑定子账号
     * @param null $id
     * @param null $subaccountId
     * @return array
     * @throws OptionsException
     */
    public function bindTelNum($id = null, $subaccountId = null)
    {
        if (empty($id)) {
            throw new OptionsException('请填写号码资源Id');
        }
        if (empty($subaccountId)) {
            throw new OptionsException('请填写子帐号Id');
        }

        $response = $this->request('POST ', $this->getBaseUrl() . self::MANAGEMENT_TELNUM ."/". $id . "/subaccount", array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }

    /**
     * 号码解绑子账号
     * @param null $id
     * @param null $subaccountId
     * @return array
     * @throws OptionsException
     */
    public function unBindTelNum($id = null, $subaccountId = null)
    {
        if (empty($id)) {
            throw new OptionsException('请填写号码资源Id');
        }
        if (empty($subaccountId)) {
            throw new OptionsException('请填写子帐号Id');
        }

        $response = $this->request('DELETE ', $this->getBaseUrl() . self::MANAGEMENT_TELNUM ."/". $id . "/subaccount", array(), array());
        return array(
            'statusCode' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'content' => $response->getContent()
        );
    }




}
