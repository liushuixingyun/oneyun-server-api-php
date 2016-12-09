<?php

namespace Oneyun\Common;

/**
 * 签名类
 * Class Encrypt
 */
class Encrypt
{
    /**
     * @param $method
     * @param $payload
     * @param $contentType
     * @param $timestamp
     * @param $appId
     * @param $apiUrl
     * @param $secret
     * @return 签名后数据
     */
    public static function create($method, $payload, $contentType, $timestamp, $appId, $apiUrl, $secret)
    {
        return self::calculateHMAC($secret, self::getSign($method, $payload, $contentType, $timestamp, $appId, $apiUrl));
    }


    /**
     * 获取签名数据
     * @param method HTTP请求方法，POST GET PUT DELETE
     * @param payload Post请求时的包体进行MD5签名
     * @param contentType HTTP请求的内容类型
     * @param timestamp 时间戳为调用时的时间以yyyyMMddHHmmss格式提供 必须同请求头中的时间戳保持一致
     * @param appId 应用APP标识
     * @param apiUri 请求的API 的地址
     * @return 返回签名内容
     */
    protected static function getSign($method, $payload, $contentType, $timestamp, $appId, $apiUrl)
    {
        $hasConent = $method ? true : false;
        $contentMd5 = isset($hasConent) ? md5($payload) : '';
        $contentType = isset($hasConent) ? $contentType : '';

        $sign = $method . "\n" . $contentMd5 . "\n" . $contentType . "\n" . $timestamp . "\n" . $appId . "\n" . $apiUrl;

        return $sign;
    }

    /**
     *HmacSHA256签名算法
     * @param secret 密钥
     * @param data 签名数据
     * @return 签名后数据
     */
    protected static function calculateHMAC($secret, $data)
    {
        $secret = hash_hmac('sha256', $data, $secret, true);

        return base64_encode($secret);

    }

}