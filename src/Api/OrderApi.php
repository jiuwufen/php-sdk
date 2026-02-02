<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Order API
 *
 * @package JiuWuFen\Sdk\Api
 */
class OrderApi
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
     * 查询商品订单信息
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getConsignOrderInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/consignOrderInfo/v1.0', $data);
    }

    /**
     * 买家地址查询
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getBuyerAddress(array $data = []): array
    {
        return $this->client->request('/api_tob/order/buyerAddress', $data);
    }

    /**
     * 自送货订单明细查询
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getConsignBatchOrderList(array $data = []): array
    {
        return $this->client->request('/api_tob/consignBatchOrderList/v1.0', $data);
    }

    /**
     * 获取订单列表（挂售）
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getOrderList(array $data = []): array
    {
        return $this->client->request('/api_tob/getOrderList/v1.0', $data);
    }
}
