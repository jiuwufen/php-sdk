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
     * 库存同步
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function syncInventory(array $data = []): array
    {
        return $this->client->request('/api_tob/inventory/sync/v1.0', $data);
    }

    /**
     * 库存查询
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getInventoryList(array $data = []): array
    {
        return $this->client->request('/api_tob/inventory/list/v1.0', $data);
    }

    /**
     * 同步库存（上下架）
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
