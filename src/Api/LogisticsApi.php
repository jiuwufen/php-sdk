<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Logistics API
 *
 * @package JiuWuFen\Sdk\Api
 */
class LogisticsApi
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
     * 商家发货并获取面单信息。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function deliveryBiz(array $data = []): array
    {
        return $this->client->request('/api_tob/delivery/bizDelivery/v1.0', $data);
    }

    /**
     * 寄售模式下,商家申请打印面单并发货。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function consignPlatformDelivery(array $data = []): array
    {
        return $this->client->request('/api_tob/platformDeliver/v1.0', $data);
    }

    /**
     * 发货到平台 (SaveExpressNumber)
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function saveExpressNumber(array $data = []): array
    {
        return $this->client->request('/api_tob/saveExpressNumber/v1.0', $data);
    }

    /**
     * 后验模式下,商家申请打印面单并发货。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function inspectLogisticsQuery(array $data = []): array
    {
        return $this->client->request('/api_tob/inspectLogisticsQuery/v1.0', $data);
    }

    /**
     * 查询后验仓地址信息。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function postVerificationWarehouseInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/postVerificationWarehouseInfo/v1.0', $data);
    }

    /**
     * 确认发货完成。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function deliveryConfirm(array $data = []): array
    {
        return $this->client->request('/api_tob/delivery/confirm/v1.0', $data);
    }

    /**
     * 查询运单物流轨迹。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function logisticsQuery(array $data = []): array
    {
        return $this->client->request('/api_tob/logisticsQuery/v1.0', $data);
    }
}
