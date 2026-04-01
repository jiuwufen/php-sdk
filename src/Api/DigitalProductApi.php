<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * DigitalProduct API
 *
 * @package JiuWuFen\Sdk\Api
 */
class DigitalProductApi
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
     * 查询 3C 数码产品的质检项配置。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function examiningConfig(array $data = []): array
    {
        return $this->client->request('/api_tob/examiningConfig/v1.0', $data);
    }

    /**
     * 查询设备 IMEI 上架状态。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function imeiQuery(array $data = []): array
    {
        return $this->client->request('/api_tob/imei/v1.0', $data);
    }

    /**
     * 平台商家一键出售 3C 数码商品。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function digitalSuperSale(array $data = []): array
    {
        return $this->client->request('/api_tob/digitalSuperSale/v1.0', $data);
    }

    /**
     * 自研商家一键出售 3C 数码商品 (V2 版本)。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function digitalSuperSaleV2(array $data = []): array
    {
        return $this->client->request('/api_tob/digitalSuperSale/v2.0', $data);
    }

    /**
     * 商家确认签收后验退回的包裹。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function inspectSignReceipt(array $data = []): array
    {
        return $this->client->request('/api_tob/inspectSignReceipt/v1.0', $data);
    }

    /**
     * 买家支付成功 30 分钟后可以进行防伪扣的绑定与换绑操作。
     *
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function bindCertificateBuckle(array $data = []): array
    {
        return $this->client->request('/api_tob/bindCertificateBuckle/v1.0', $data);
    }
}
