# 95分开放平台 PHP SDK

[![Packagist Version](https://img.shields.io/badge/packagist-1.0.0-blue)](https://packagist.org/packages/jiuwufen/jiuwufen-sdk)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

95分开放平台的官方 PHP SDK，提供完整的 API 调用能力，包括商品管理、订单处理、库存同步等功能。

## ✨ 特性

- 🐘 **现代 PHP** - 支持 PHP 7.4+ 和 PHP 8.x
- 🔐 **自动签名** - 内置 MD5 + Base64 签名算法
- 🔒 **地址解密** - 支持 AES-ECB 买家地址解密
- 📦 **完整 API** - 覆盖所有开放平台接口
- 🎯 **类型安全** - 完整的类型声明
- 🔄 **PSR-4 自动加载** - 符合 PSR-4 规范
- 📝 **详细日志** - 支持调试模式查看请求详情
- ⚡ **高性能** - 基于 Guzzle 的高性能 HTTP 客户端

## 📦 安装

### 使用 Composer

```bash
composer require jiuwufen/jiuwufen-sdk
```

## 🚀 快速开始

### 1. 创建客户端

```php
<?php

require_once 'vendor/autoload.php';

use JiuWuFen\Sdk\JiuWuFenClient;

$client = new JiuWuFenClient(
    erpName: 'your-erp-name',              // ERP 名称（由95分提供）
    thirdPartyId: 'your-third-party-id',   // 第三方应用标识
    merchantSecret: 'your-merchant-secret', // 商家密钥
    platformSecret: 'your-platform-secret', // 平台密钥
    baseUrl: 'http://d1.95fenapp.com',     // 开发环境
    timeout: 30,                            // 请求超时（秒）
    debug: true                             // 开启调试模式
);
```

### 2. 商户入驻

```php
use JiuWuFen\Sdk\Exception\ApiException;

try {
    // 发送短信验证码
    $response = $client->merchant()->sendSMSCaptcha([
        'mobile' => '13800000000',
    ]);
    echo "验证码已发送\n";

    // 校验短信验证码
    $response = $client->merchant()->checkSMSCaptcha([
        'mobile' => '13800000000',
        'captcha' => '123456',
    ]);
    echo "应用标识: " . $response['hearder_name'] . "\n";
    echo "应用密钥: " . $response['secret_key'] . "\n";
} catch (ApiException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}
```

### 3. 商品管理

```php
// 新增商品
$response = $client->goods()->addOrderGoods([
    'goods_sn' => 'GOODS-2024-001',
    'title' => 'Nike Air Max 90 经典复古跑鞋',
    'brand_id' => 2,
    'l1_category_id' => 1,
    'l2_category_id' => 10,
    'first_img' => 'https://example.com/nike-air-max-90-main.jpg',
    'general_imgs' => [
        'https://example.com/nike-air-max-90-1.jpg',
        'https://example.com/nike-air-max-90-2.jpg',
    ],
    'price' => 29900,  // 价格单位：分
    'quality' => 20,
]);
echo "商品添加成功!\n";
```

### 4. 库存同步

```php
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
echo "库存同步完成\n";
```

### 5. 订单查询

```php
$response = $client->order()->getConsignOrderInfo([
    'order_number' => ['95025032898155673463'],
    'page' => 1,
    'page_size' => 20,
]);

foreach ($response['order_list'] ?? [] as $order) {
    echo "订单号: " . $order['sell_order_number'] . "\n";
    echo "状态: " . $order['status_desc'] . "\n";
}
```

## 📚 API 列表

### 平台商户入驻 (2个接口)

| 方法 | 说明 |
|------|------|
| `merchant()->sendSMSCaptcha()` | 发送短信验证码 |
| `merchant()->checkSMSCaptcha()` | 校验短信验证码 |

### 商品管理 (11个接口)

| 方法 | 说明 |
|------|------|
| `goods()->getMerchantSkuList()` | 查询SKU列表（绑定关系） |
| `goods()->addOrderGoods()` | 新增商品 |
| `goods()->getGoodsInfo()` | 查询商品状态信息 |
| `goods()->updatePrice()` | 改价 |
| `goods()->cancelOrder()` | 下架商品 |
| `goods()->updateSellerBargain()` | 卖家议价 |
| `goods()->bargainSuccess()` | 卖家接受还价 |
| `goods()->queryProperties()` | 获取类目属性 |
| `goods()->getBrandIdentifyAbility()` | 可鉴品牌查询 |
| `goods()->copyOnSale()` | 复制订单上架 |
| `goods()->getReferencePrice()` | 订单参考价查询 |

### 库存管理 (3个接口)

| 方法 | 说明 |
|------|------|
| `inventory()->syncInventory()` | 库存同步 |
| `inventory()->getInventoryList()` | 库存查询 |
| `inventory()->updateStock()` | 同步库存（上下架） |

### 订单管理 (4个接口)

| 方法 | 说明 |
|------|------|
| `order()->getConsignOrderInfo()` | 查询商品订单信息 |
| `order()->getBuyerAddress()` | 买家地址查询 |
| `order()->getConsignBatchOrderList()` | 自送货订单明细查询 |
| `order()->getOrderList()` | 获取订单列表（挂售） |

### 物流管理 (1个接口)

| 方法 | 说明 |
|------|------|
| `delivery()->deliveryBiz()` | 发货 & 重打面单 |

## ⚙️ 配置选项

### 环境配置

```php
// 开发环境
$baseUrl = 'http://d1.95fenapp.com';

// 测试环境
$baseUrl = 'http://t1.95fenapp.com';

// 预发环境
$baseUrl = 'http://stg-www.95fenapp.com';

// 生产环境
$baseUrl = 'http://www.95fenapp.com';
```

### 超时配置

```php
$client = new JiuWuFenClient(
    // ... 其他配置
    timeout: 30  // 请求超时：30秒
);
```

### 调试模式

```php
$client = new JiuWuFenClient(
    // ... 其他配置
    debug: true  // 开启调试模式，打印请求和响应详情
);
```

## 🔧 高级功能

### 错误处理

```php
use JiuWuFen\Sdk\Exception\ApiException;

try {
    $response = $client->goods()->addOrderGoods($data);
    echo "成功\n";
} catch (ApiException $e) {
    echo "错误码: " . $e->getCode() . "\n";
    echo "错误信息: " . $e->getErrorMessage() . "\n";
    echo "请求ID: " . $e->getReqId() . "\n";
    
    if ($e->isBusinessError()) {
        // 处理业务错误
        echo "业务错误，请检查参数\n";
    } elseif ($e->isNetworkError()) {
        // 处理网络错误
        echo "网络错误，请稍后重试\n";
    }
}
```

### 地址解密

```php
use JiuWuFen\Sdk\Utils\SignatureUtil;

// 获取加密的买家地址
$response = $client->order()->getBuyerAddress([
    'order_number' => '95025032898155673463',
]);

// 解密地址
$key = 'your-platform-secret';
$decryptedAddress = SignatureUtil::decryptAddress(
    $response['address'],
    $key
);
echo "买家地址: {$decryptedAddress}\n";
```

### 签名验证（用于回调）

```php
use JiuWuFen\Sdk\Utils\SignatureUtil;

$util = new SignatureUtil($merchantSecret, $platformSecret);

// 验证回调签名
$params = [
    'goods_sn' => 'GOODS-001',
    'price' => 29900,
    // ... 其他参数
];

$receivedToken = $_POST['token'] ?? '';

if ($util->verifySignature($params, $receivedToken)) {
    echo "签名验证通过\n";
} else {
    echo "签名验证失败\n";
}
```

## 🧪 测试

```bash
# 安装依赖
composer install

# 运行测试
composer test

# 或直接使用 PHPUnit
./vendor/bin/phpunit
```

## 📖 文档

- [API 详细文档](docs/API.md)
- [快速开始指南](docs/QUICKSTART.md)
- [常见问题](docs/FAQ.md)

## 🤝 贡献

欢迎提交 Issue 和 Pull Request！

## 📄 许可证

MIT License

## 📞 技术支持

- GitHub: https://github.com/jiuwufen/php-sdk
- Issues: https://github.com/jiuwufen/php-sdk/issues
- Email: support@95fenapp.com

## 🎯 版本历史

### v1.0.0 (2024-02-02)

- ✅ 完整的 API 实现（21个接口）
- ✅ PSR-4 自动加载
- ✅ 自动签名和加解密
- ✅ 完善的错误处理
- ✅ 详细的文档和示例
- ✅ 完整的单元测试
