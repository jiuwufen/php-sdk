<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Goods API
 *
 * @package JiuWuFen\Sdk\Api
 */
class GoodsApi
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
     * 查询SKU列表（绑定关系）
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getMerchantSkuList(array $data = []): array
    {
        return $this->client->request('/api_tob/merchantSkuList/v1.0', $data);
    }

    /**
     * 新增商品
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function addOrderGoods(array $data = []): array
    {
        return $this->client->request('/api_tob/addOrderGoods/v1.0', $data);
    }

    /**
     * 查询商品状态信息
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getGoodsInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/goodsInfo/v1.0', $data);
    }

    /**
     * 改价
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function updatePrice(array $data = []): array
    {
        return $this->client->request('/api_tob/updatePrice/v1.0', $data);
    }

    /**
     * 下架商品
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function cancelOrder(array $data = []): array
    {
        return $this->client->request('/api_tob/cancelOrder/v1.0', $data);
    }

    /**
     * 卖家议价
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function updateSellerBargain(array $data = []): array
    {
        return $this->client->request('/api_tob/updateSellerBargain/v1.0', $data);
    }

    /**
     * 卖家接受还价
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function bargainSuccess(array $data = []): array
    {
        return $this->client->request('/api_tob/bargainSuccess/v1.0', $data);
    }

    /**
     * 获取类目属性
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function queryProperties(array $data = []): array
    {
        return $this->client->request('/api_tob/query_properties/v1.0', $data);
    }

    /**
     * 可鉴品牌查询
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getBrandIdentifyAbility(array $data = []): array
    {
        return $this->client->request('/api_tob/get_brand_identify_ability/v1.0', $data);
    }

    /**
     * 复制订单上架
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function copyOnSale(array $data = []): array
    {
        return $this->client->request('/api_tob/copyOnSale/v1.0', $data);
    }

    /**
     * 订单参考价查询
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function getReferencePrice(array $data = []): array
    {
        return $this->client->request('/api_tob/referencePrice/v1.0', $data);
    }
}
