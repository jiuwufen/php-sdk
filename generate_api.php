#!/usr/bin/env php
<?php
/**
 * PHP SDK API 类生成器
 */

$baseDir = __DIR__ . '/src/Api';

// API 定义
$apis = [
    'Merchant' => [
        'methods' => [
            ['name' => 'sendSMSCaptcha', 'path' => '/api_tob/erpSendSmsCaptcha/v1.0', 'doc' => '发送短信验证码'],
            ['name' => 'checkSMSCaptcha', 'path' => '/api_tob/erpCheckSmsCaptcha/v1.0', 'doc' => '校验短信验证码'],
        ],
    ],
    'Goods' => [
        'methods' => [
            ['name' => 'getMerchantSkuList', 'path' => '/api_tob/merchantSkuList/v1.0', 'doc' => '查询SKU列表（绑定关系）'],
            ['name' => 'addOrderGoods', 'path' => '/api_tob/addOrderGoods/v1.0', 'doc' => '新增商品'],
            ['name' => 'getGoodsInfo', 'path' => '/api_tob/goodsInfo/v1.0', 'doc' => '查询商品状态信息'],
            ['name' => 'updatePrice', 'path' => '/api_tob/updatePrice/v1.0', 'doc' => '改价'],
            ['name' => 'cancelOrder', 'path' => '/api_tob/cancelOrder/v1.0', 'doc' => '下架商品'],
            ['name' => 'updateSellerBargain', 'path' => '/api_tob/updateSellerBargain/v1.0', 'doc' => '卖家议价'],
            ['name' => 'bargainSuccess', 'path' => '/api_tob/bargainSuccess/v1.0', 'doc' => '卖家接受还价'],
            ['name' => 'queryProperties', 'path' => '/api_tob/query_properties/v1.0', 'doc' => '获取类目属性'],
            ['name' => 'getBrandIdentifyAbility', 'path' => '/api_tob/get_brand_identify_ability/v1.0', 'doc' => '可鉴品牌查询'],
            ['name' => 'copyOnSale', 'path' => '/api_tob/copyOnSale/v1.0', 'doc' => '复制订单上架'],
            ['name' => 'getReferencePrice', 'path' => '/api_tob/referencePrice/v1.0', 'doc' => '订单参考价查询'],
        ],
    ],
    'Inventory' => [
        'methods' => [
            ['name' => 'syncInventory', 'path' => '/api_tob/inventory/sync/v1.0', 'doc' => '库存同步'],
            ['name' => 'getInventoryList', 'path' => '/api_tob/inventory/list/v1.0', 'doc' => '库存查询'],
            ['name' => 'updateStock', 'path' => '/api_tob/updateStock/v1.0', 'doc' => '同步库存（上下架）'],
        ],
    ],
    'Order' => [
        'methods' => [
            ['name' => 'getConsignOrderInfo', 'path' => '/api_tob/consignOrderInfo/v1.0', 'doc' => '查询商品订单信息'],
            ['name' => 'getBuyerAddress', 'path' => '/api_tob/order/buyerAddress', 'doc' => '买家地址查询'],
            ['name' => 'getConsignBatchOrderList', 'path' => '/api_tob/consignBatchOrderList/v1.0', 'doc' => '自送货订单明细查询'],
            ['name' => 'getOrderList', 'path' => '/api_tob/getOrderList/v1.0', 'doc' => '获取订单列表（挂售）'],
        ],
    ],
    'Delivery' => [
        'methods' => [
            ['name' => 'deliveryBiz', 'path' => '/api_tob/delivery/bizDelivery/v1.0', 'doc' => '发货 & 重打面单'],
        ],
    ],
];

function generateApiClass($className, $apiDef)
{
    $methods = $apiDef['methods'];
    
    $code = "<?php\n\n";
    $code .= "namespace JiuWuFen\\Sdk\\Api;\n\n";
    $code .= "use JiuWuFen\\Sdk\\JiuWuFenClient;\n";
    $code .= "use JiuWuFen\\Sdk\\Exception\\ApiException;\n\n";
    $code .= "/**\n";
    $code .= " * {$className} API\n";
    $code .= " *\n";
    $code .= " * @package JiuWuFen\\Sdk\\Api\n";
    $code .= " */\n";
    $code .= "class {$className}Api\n";
    $code .= "{\n";
    $code .= "    /**\n";
    $code .= "     * @var JiuWuFenClient 客户端实例\n";
    $code .= "     */\n";
    $code .= "    private JiuWuFenClient \$client;\n\n";
    $code .= "    /**\n";
    $code .= "     * 构造函数\n";
    $code .= "     *\n";
    $code .= "     * @param JiuWuFenClient \$client\n";
    $code .= "     */\n";
    $code .= "    public function __construct(JiuWuFenClient \$client)\n";
    $code .= "    {\n";
    $code .= "        \$this->client = \$client;\n";
    $code .= "    }\n";
    
    foreach ($methods as $method) {
        $methodName = $method['name'];
        $path = $method['path'];
        $doc = $method['doc'];
        
        $code .= "\n";
        $code .= "    /**\n";
        $code .= "     * {$doc}\n";
        $code .= "     *\n";
        $code .= "     * @param array \$data 请求数据\n";
        $code .= "     * @return array 响应数据\n";
        $code .= "     * @throws ApiException\n";
        $code .= "     */\n";
        $code .= "    public function {$methodName}(array \$data = []): array\n";
        $code .= "    {\n";
        $code .= "        return \$this->client->request('{$path}', \$data);\n";
        $code .= "    }\n";
    }
    
    $code .= "}\n";
    
    return $code;
}

// 生成 API 类
if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

echo "开始生成 PHP SDK API 类...\n";

foreach ($apis as $className => $apiDef) {
    $code = generateApiClass($className, $apiDef);
    $filePath = $baseDir . '/' . $className . 'Api.php';
    
    file_put_contents($filePath, $code);
    echo "✅ 生成: Api/{$className}Api.php\n";
}

echo "\n✨ 所有 API 类生成完成！\n";
