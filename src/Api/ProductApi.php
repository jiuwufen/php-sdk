<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Product API
 *
 * @package JiuWuFen\Sdk\Api
 */
class ProductApi
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
     * 定时拉取绑定关系,查询绑定关系,至少时间范围要拉取前一天的。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function skuListBinding(array $data = []): array
    {
        return $this->client->request('/api_tob/merchantSkuList/v1.0', $data);
    }

    /**
     * 通用查询,不限制商品绑定。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function skuListGeneral(array $data = []): array
    {
        return $this->client->request('/api_tob/skuList/v1.0', $data);
    }

    /**
     * 新增商品接口。
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
     * 查询商品的上架状态及详情链接。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function goodsInfo(array $data = []): array
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
     * 卖家议价 (UpdateSellerBargain)
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
     * 卖家接受还价 (BargainSuccess)
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
     * 通过叶子类目 ID 获取 95 分该类目下具体的销售属性列表。
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
     * 通过一级类目 ID 和品牌名称获取 95 分可鉴品牌列表,返回前 100 个符合条件的品牌信息。支持模糊查询。
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
     * 复制订单上架 (CopyOnSale)
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
     * 查询参考价格,包含平台最低价、寄售最低价、最近成交均价、全新市场价、平台限价(3C专属,为最高出价限制)。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function referencePrice(array $data = []): array
    {
        return $this->client->request('/api_tob/referencePrice/v1.0', $data);
    }
}
