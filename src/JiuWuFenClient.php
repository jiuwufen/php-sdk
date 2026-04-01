<?php

namespace JiuWuFen\Sdk;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use JiuWuFen\Sdk\Api\DigitalProductApi;
use JiuWuFen\Sdk\Api\InventoryApi;
use JiuWuFen\Sdk\Api\LogisticsApi;
use JiuWuFen\Sdk\Api\MerchantOnboardingApi;
use JiuWuFen\Sdk\Api\OrderApi;
use JiuWuFen\Sdk\Api\ProductApi;
use JiuWuFen\Sdk\Api\ReturnApi;
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





    private DigitalProductApi $digitalProductApi;
    private InventoryApi $inventoryApi;
    private LogisticsApi $logisticsApi;
    private MerchantOnboardingApi $merchantOnboardingApi;
    private OrderApi $orderApi;
    private ProductApi $productApi;
    private ReturnApi $returnApi;

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
        $this->digitalProductApi = new DigitalProductApi($this);
        $this->inventoryApi = new InventoryApi($this);
        $this->logisticsApi = new LogisticsApi($this);
        $this->merchantOnboardingApi = new MerchantOnboardingApi($this);
        $this->orderApi = new OrderApi($this);
        $this->productApi = new ProductApi($this);
        $this->returnApi = new ReturnApi($this);

        // 初始化 API 服务
    }

    public function getDigitalProductApi(): DigitalProductApi
    {
        return $this->digitalProductApi;
    }

    public function getInventoryApi(): InventoryApi
    {
        return $this->inventoryApi;
    }

    public function getLogisticsApi(): LogisticsApi
    {
        return $this->logisticsApi;
    }

    public function getMerchantOnboardingApi(): MerchantOnboardingApi
    {
        return $this->merchantOnboardingApi;
    }

    public function getOrderApi(): OrderApi
    {
        return $this->orderApi;
    }

    public function getProductApi(): ProductApi
    {
        return $this->productApi;
    }

    public function getReturnApi(): ReturnApi
    {
        return $this->returnApi;
    }
}
