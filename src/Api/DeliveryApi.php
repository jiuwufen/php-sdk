<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Delivery API
 *
 * @package JiuWuFen\Sdk\Api
 */
class DeliveryApi
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
     * 发货 & 重打面单
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function deliveryBiz(array $data = []): array
    {
        return $this->client->request('/api_tob/delivery/bizDelivery/v1.0', $data);
    }
}
