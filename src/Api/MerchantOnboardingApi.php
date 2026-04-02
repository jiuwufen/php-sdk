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
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - mobile (string, 必填): 商家 95 分账号对应手机号
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 返回数据
     *     - req_id (string, 必填): 请求 ID
     *     - status (int, 必填): 状态码(0 成功)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
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
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - captcha (string, 必填): 验证码
     *     - mobile (string, 必填): 手机号
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.hearder_name (string, 必填): 平台商户应用标识
     *       - data.secret_key (string, 必填): 平台商户应用密钥
     *     - status (int, 必填): 状态码
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function checkSms(array $data = []): array
    {
        return $this->client->request('/api_tob/erpCheckSmsCaptcha/v1.0', $data);
    }
}
