<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Inventory API
 *
 * @package JiuWuFen\Sdk\Api
 */
class InventoryApi
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
     * 95 分平台的库存变更,三方要保证 95 分库存售出操作了发货确认后实时同步总库存的变更。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function inventorySync(array $data = []): array
    {
        return $this->client->request('/api_tob/inventory/sync/v1.0', $data);
    }

    /**
     * 查询当前库存状态。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function inventoryList(array $data = []): array
    {
        return $this->client->request('/api_tob/inventory/list/v1.0', $data);
    }

    /**
     * 同步库存 (UpdateStock)
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function updateStock(array $data = []): array
    {
        return $this->client->request('/api_tob/updateStock/v1.0', $data);
    }
}
