<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * MerchantOnboarding API
 *
 * @package JiuWuFen\Sdk\Api
 */
class MerchantOnboardingApi
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
     * 发送短信验证码至商家要入驻 95 分账号对应的手机号。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function sendSms(array $data = []): array
    {
        return $this->client->request('/api_tob/erpSendSmsCaptcha/v1.0', $data);
    }

    /**
     * 校验验证码是否正确,完成入驻商家基本数据初始化。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function checkSms(array $data = []): array
    {
        return $this->client->request('/api_tob/erpCheckSmsCaptcha/v1.0', $data);
    }
}
