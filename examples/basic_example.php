<?php

require_once __DIR__ . '/../vendor/autoload.php';

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

// 创建客户端
$client = new JiuWuFenClient(
    erpName: 'your-erp-name',
    thirdPartyId: 'your-third-party-id',
    merchantSecret: 'your-merchant-secret',
    platformSecret: 'your-platform-secret',
    baseUrl: 'http://d1.95fenapp.com',
    timeout: 30,
    debug: true
);

try {
    // 示例1: 发送短信验证码
    echo "=== 示例1: 发送短信验证码 ===\n";
    $response = $client->merchant()->sendSMSCaptcha([
        'mobile' => '13800000000',
    ]);
    echo "验证码已发送: " . json_encode($response, JSON_UNESCAPED_UNICODE) . "\n";

    // 示例2: 校验短信验证码
    echo "\n=== 示例2: 校验短信验证码 ===\n";
    $response = $client->merchant()->checkSMSCaptcha([
        'mobile' => '13800000000',
        'captcha' => '123456',
    ]);
    echo "校验成功: " . json_encode($response, JSON_UNESCAPED_UNICODE) . "\n";

    // 示例3: 新增商品
    echo "\n=== 示例3: 新增商品 ===\n";
    $response = $client->goods()->addOrderGoods([
        'goods_sn' => 'GOODS-2024-001',
        'title' => 'Nike Air Max 90',
        'brand_id' => 2,
        'l1_category_id' => 1,
        'l2_category_id' => 10,
        'first_img' => 'https://example.com/img1.jpg',
        'general_imgs' => ['https://example.com/img2.jpg'],
        'price' => 29900,
        'quality' => 20,
    ]);
    echo "商品添加成功: " . json_encode($response, JSON_UNESCAPED_UNICODE) . "\n";

    // 示例4: 库存同步
    echo "\n=== 示例4: 库存同步 ===\n";
    $response = $client->inventory()->syncInventory([
        'detail' => [
            [
                'merchant_sku_code' => 'SKU-001',
                'sku_id' => 1390873,
                'qty' => 100,
                'salable_qty' => 90,
            ],
        ],
    ]);
    echo "库存同步结果: " . json_encode($response, JSON_UNESCAPED_UNICODE) . "\n";

    // 示例5: 查询订单
    echo "\n=== 示例5: 查询订单 ===\n";
    $response = $client->order()->getConsignOrderInfo([
        'order_number' => ['95025032898155673463'],
        'page' => 1,
        'page_size' => 20,
    ]);
    echo "订单列表: " . json_encode($response, JSON_UNESCAPED_UNICODE) . "\n";

    // 示例6: 错误处理
    echo "\n=== 示例6: 错误处理示例 ===\n";
    try {
        $client->goods()->getGoodsInfo(['goods_sn' => 'INVALID_GOODS_SN']);
    } catch (ApiException $e) {
        echo "业务错误:\n";
        echo "  错误码: " . $e->getCode() . "\n";
        echo "  错误信息: " . $e->getErrorMessage() . "\n";
        echo "  请求ID: " . $e->getReqId() . "\n";

        if ($e->isBusinessError()) {
            echo "  类型: 业务错误\n";
        } elseif ($e->isNetworkError()) {
            echo "  类型: 网络错误\n";
        }
    }

    echo "\n=== 基础示例完成 ===\n";
} catch (ApiException $e) {
    echo "API 异常: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "未知异常: " . $e->getMessage() . "\n";
}
