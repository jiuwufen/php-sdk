<?php

namespace JiuWuFen\Sdk;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use JiuWuFen\Sdk\Api\MerchantApi;
use JiuWuFen\Sdk\Api\GoodsApi;
use JiuWuFen\Sdk\Api\InventoryApi;
use JiuWuFen\Sdk\Api\OrderApi;
use JiuWuFen\Sdk\Api\DeliveryApi;
use JiuWuFen\Sdk\Exception\ApiException;
use JiuWuFen\Sdk\Utils\SignatureUtil;

/**
 * 95分开放平台 SDK 客户端
 *
 * @package JiuWuFen\Sdk
 */
class JiuWuFenClient
{
    /**
     * @var string ERP 名称
     */
    private string $erpName;

    /**
     * @var string 第三方应用标识
     */
    private string $thirdPartyId;

    /**
     * @var string 商家密钥
     */
    private string $merchantSecret;

    /**
     * @var string 平台密钥
     */
    private string $platformSecret;

    /**
     * @var string API 基础 URL
     */
    private string $baseUrl;

    /**
     * @var int 请求超时时间（秒）
     */
    private int $timeout;

    /**
     * @var bool 是否开启调试模式
     */
    private bool $debug;

    /**
     * @var HttpClient HTTP 客户端
     */
    private HttpClient $httpClient;

    /**
     * @var SignatureUtil 签名工具
     */
    private SignatureUtil $signatureUtil;

    /**
     * @var MerchantApi 商户 API
     */
    private MerchantApi $merchantApi;

    /**
     * @var GoodsApi 商品 API
     */
    private GoodsApi $goodsApi;

    /**
     * @var InventoryApi 库存 API
     */
    private InventoryApi $inventoryApi;

    /**
     * @var OrderApi 订单 API
     */
    private OrderApi $orderApi;

    /**
     * @var DeliveryApi 物流 API
     */
    private DeliveryApi $deliveryApi;

    /**
     * 构造函数
     *
     * @param string $erpName ERP 名称（由95分提供）
     * @param string $thirdPartyId 第三方应用标识（由95分提供）
     * @param string $merchantSecret 商家密钥（入驻后获取）
     * @param string $platformSecret 平台密钥（由95分提供）
     * @param string $baseUrl API 基础 URL
     * @param int $timeout 请求超时时间（秒）
     * @param bool $debug 是否开启调试模式
     */
    public function __construct(
        string $erpName,
        string $thirdPartyId,
        string $merchantSecret,
        string $platformSecret,
        string $baseUrl = 'http://www.95fenapp.com',
        int $timeout = 30,
        bool $debug = false
    ) {
        if (empty($erpName)) {
            throw new \InvalidArgumentException('erpName is required');
        }
        if (empty($thirdPartyId)) {
            throw new \InvalidArgumentException('thirdPartyId is required');
        }
        if (empty($merchantSecret)) {
            throw new \InvalidArgumentException('merchantSecret is required');
        }
        if (empty($platformSecret)) {
            throw new \InvalidArgumentException('platformSecret is required');
        }

        $this->erpName = $erpName;
        $this->thirdPartyId = $thirdPartyId;
        $this->merchantSecret = $merchantSecret;
        $this->platformSecret = $platformSecret;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->timeout = $timeout;
        $this->debug = $debug;

        // 初始化 HTTP 客户端
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
                'x-request-sign-version' => 'm1',
                'fen95-external-third-erp-name' => $this->erpName,
                'fen95-external-third' => $this->thirdPartyId,
            ],
        ]);

        // 初始化签名工具
        $this->signatureUtil = new SignatureUtil($merchantSecret, $platformSecret);

        // 初始化 API 服务
        $this->merchantApi = new MerchantApi($this);
        $this->goodsApi = new GoodsApi($this);
        $this->inventoryApi = new InventoryApi($this);
        $this->orderApi = new OrderApi($this);
        $this->deliveryApi = new DeliveryApi($this);
    }

    /**
     * 获取商户 API
     *
     * @return MerchantApi
     */
    public function merchant(): MerchantApi
    {
        return $this->merchantApi;
    }

    /**
     * 获取商品 API
     *
     * @return GoodsApi
     */
    public function goods(): GoodsApi
    {
        return $this->goodsApi;
    }

    /**
     * 获取库存 API
     *
     * @return InventoryApi
     */
    public function inventory(): InventoryApi
    {
        return $this->inventoryApi;
    }

    /**
     * 获取订单 API
     *
     * @return OrderApi
     */
    public function order(): OrderApi
    {
        return $this->orderApi;
    }

    /**
     * 获取物流 API
     *
     * @return DeliveryApi
     */
    public function delivery(): DeliveryApi
    {
        return $this->deliveryApi;
    }

    /**
     * 执行 HTTP 请求
     *
     * @param string $path 请求路径
     * @param array $data 请求数据
     * @return array 响应数据
     * @throws ApiException
     */
    public function request(string $path, array $data = []): array
    {
        // 处理时间戳（如果没有传入，则自动添加当前时间戳，单位：秒）
        if (!isset($data['timestamp'])) {
            $data['timestamp'] = (string)time();
        }

        // 生成签名
        $signature = $this->signatureUtil->generateSignature($data);
        $data['token'] = $signature;

        // 构建 URL
        $url = $this->baseUrl . $path;

        if ($this->debug) {
            error_log("Request URL: {$url}");
            error_log("Request Data: " . json_encode($data, JSON_UNESCAPED_UNICODE));
        }

        try {
            // 发送请求
            $response = $this->httpClient->post($path, [
                'json' => $data,
            ]);

            $body = (string)$response->getBody();

            if ($this->debug) {
                error_log("Response Status: " . $response->getStatusCode());
                error_log("Response Body: {$body}");
            }

            // 解析响应
            $result = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException(
                    -1,
                    'Invalid JSON response: ' . json_last_error_msg(),
                    ''
                );
            }

            // 检查业务状态码
            $status = $result['status'] ?? -1;
            if ($status !== 0) {
                throw new ApiException(
                    $status,
                    $result['msg'] ?? 'Unknown error',
                    $result['req_id'] ?? ''
                );
            }

            return $result['data'] ?? [];
        } catch (GuzzleException $e) {
            throw new ApiException(
                -1,
                'Network error: ' . $e->getMessage(),
                ''
            );
        }
    }

    /**
     * 获取签名工具
     *
     * @return SignatureUtil
     */
    public function getSignatureUtil(): SignatureUtil
    {
        return $this->signatureUtil;
    }
}
