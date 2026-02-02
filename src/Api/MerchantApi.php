<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Merchant API
 *
 * @package JiuWuFen\Sdk\Api
 */
class MerchantApi
{
    /**
     * @var JiuWuFenClient 客户端实例
     */
    private JiuWuFenClient $client;

    /**
     * 构造函数
     *
     * @param JiuWuFenClient $client
     */
    public function __construct(JiuWuFenClient $client)
    {
        $this->client = $client;
    }

    /**
     * 发送短信验证码
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function sendSMSCaptcha(array $data = []): array
    {
        return $this->client->request('/api_tob/erpSendSmsCaptcha/v1.0', $data);
    }

    /**
     * 校验短信验证码
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function checkSMSCaptcha(array $data = []): array
    {
        return $this->client->request('/api_tob/erpCheckSmsCaptcha/v1.0', $data);
    }
}
