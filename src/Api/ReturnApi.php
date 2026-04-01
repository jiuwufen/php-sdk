<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Return API
 *
 * @package JiuWuFen\Sdk\Api
 */
class ReturnApi
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
     * 查询退货订单列表。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundList(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/list/v1.0', $data);
    }

    /**
     * 商家确认签收退货。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundConfirm(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/confirmReceive', $data);
    }

    /**
     * 查询买家退回的地址 (加密)。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundBuyerAddress(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/backBuyerAddress', $data);
    }

    /**
     * 退货审核不通过时,发货退回给买家。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundSuccess(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/refundSuccess', $data);
    }

    /**
     * 查询退货订单列表详情。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundOrderInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/refundOrderInfo/v1.0', $data);
    }
}
