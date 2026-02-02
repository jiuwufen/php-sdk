<?php

namespace JiuWuFen\Sdk\Tests;

use PHPUnit\Framework\TestCase;
use JiuWuFen\Sdk\Utils\SignatureUtil;

/**
 * 签名工具测试类
 */
class SignatureUtilTest extends TestCase
{
    private string $merchantSecret = 'merchant_secret_123';
    private string $platformSecret = 'platform_secret_456';
    private SignatureUtil $util;

    protected function setUp(): void
    {
        $this->util = new SignatureUtil($this->merchantSecret, $this->platformSecret);
    }

    public function testGenerateSignature(): void
    {
        $params = ['mobile' => '13800000000'];
        $signature = $this->util->generateSignature($params);

        $this->assertNotNull($signature);
        $this->assertEquals(32, strlen($signature)); // MD5 长度为 32
    }

    public function testGenerateSignatureWithMultipleParams(): void
    {
        $params = [
            'b' => '2',
            'a' => '1',
            'c' => '3',
        ];
        $signature = $this->util->generateSignature($params);

        $this->assertNotNull($signature);
        $this->assertEquals(32, strlen($signature));
    }

    public function testVerifySignature(): void
    {
        $params = ['mobile' => '13800000000'];

        // 生成签名
        $signature = $this->util->generateSignature($params);

        // 验证签名
        $this->assertTrue($this->util->verifySignature($params, $signature));

        // 验证错误的签名
        $this->assertFalse($this->util->verifySignature($params, 'invalid_signature'));
    }

    public function testEncryptDecryptAddress(): void
    {
        $plainText = '上海市浦东新区张江高科技园区';
        $key = '12345678901234567890123456789012'; // 32字节密钥

        // 加密
        $cipherText = SignatureUtil::encryptAddress($plainText, $key);
        $this->assertNotNull($cipherText);
        $this->assertNotEmpty($cipherText);

        // 解密
        $decrypted = SignatureUtil::decryptAddress($cipherText, $key);
        $this->assertEquals($plainText, $decrypted);
    }

    public function testSignatureConsistency(): void
    {
        $params = [
            'goods_sn' => 'GOODS-001',
            'price' => 29900,
        ];

        $signature1 = $this->util->generateSignature($params);
        $signature2 = $this->util->generateSignature($params);

        // 相同参数应该生成相同的签名
        $this->assertEquals($signature1, $signature2);
    }
}
