<?php

namespace JiuWuFen\Sdk\Utils;

/**
 * 签名和加解密工具类
 *
 * @package JiuWuFen\Sdk\Utils
 */
class SignatureUtil
{
    /**
     * @var string 商家密钥
     */
    private string $merchantSecret;

    /**
     * @var string 平台密钥
     */
    private string $platformSecret;

    /**
     * 构造函数
     *
     * @param string $merchantSecret 商家密钥
     * @param string $platformSecret 平台密钥
     */
    public function __construct(string $merchantSecret, string $platformSecret)
    {
        $this->merchantSecret = $merchantSecret;
        $this->platformSecret = $platformSecret;
    }

    /**
     * 生成请求签名
     *
     * 算法: token = md5(base64_encode(商家密钥 + 平台密钥) + 排序并拼接后的参数字符串)
     *
     * @param array $params 请求参数
     * @return string 签名字符串
     */
    public function generateSignature(array $params): string
    {
        // 与其它 SDK / GenSign 一致：整型语义的 float 归一为 int，避免 json_encode 差异
        $params = $this->normalizeIntegralTree($params);

        // 1. 获取所有 Keys 并排序（排除 token 本身）
        $keys = array_keys($params);
        $keys = array_filter($keys, function ($key) {
            return $key !== 'token';
        });
        sort($keys);

        // 2. 拼接参数值（仅 string 原样拼接，其余 json_encode，含 null→null）
        $paramsStr = '';
        foreach ($keys as $key) {
            $value = $params[$key];
            if (is_string($value)) {
                $paramsStr .= $value;
            } else {
                $paramsStr .= json_encode(
                    $this->sortArrayKeys($value),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );
            }
        }

        // 3. Base64 编码密钥
        $secret = $this->merchantSecret . $this->platformSecret;
        $base64Secret = base64_encode($secret);

        // 4. 拼接并计算 MD5
        $finalStr = $base64Secret . $paramsStr;
        return md5($finalStr);
    }

    /**
     * 验证签名
     *
     * @param array $params 请求参数
     * @param string $expectedToken 期望的签名
     * @return bool 是否验证通过
     */
    public function verifySignature(array $params, string $expectedToken): bool
    {
        $actualToken = $this->generateSignature($params);
        return $actualToken === $expectedToken;
    }

    /**
     * 解密地址
     *
     * 使用 AES-ECB 模式解密地址字符串
     *
     * @param string $cipherText 密文（Base64 编码）
     * @param string $key 密钥
     * @return string 明文地址
     */
    public static function decryptAddress(string $cipherText, string $key): string
    {
        // Base64 解码密文
        $cipherBytes = base64_decode($cipherText);

        // 解密
        $plainBytes = openssl_decrypt(
            $cipherBytes,
            'AES-256-ECB',
            $key,
            OPENSSL_RAW_DATA
        );

        if ($plainBytes === false) {
            throw new \RuntimeException('Failed to decrypt address');
        }

        return $plainBytes;
    }

    /**
     * 加密地址（用于测试）
     *
     * @param string $plainText 明文
     * @param string $key 密钥
     * @return string 密文（Base64 编码）
     */
    public static function encryptAddress(string $plainText, string $key): string
    {
        // 加密
        $cipherBytes = openssl_encrypt(
            $plainText,
            'AES-256-ECB',
            $key,
            OPENSSL_RAW_DATA
        );

        if ($cipherBytes === false) {
            throw new \RuntimeException('Failed to encrypt address');
        }

        // Base64 编码
        return base64_encode($cipherBytes);
    }

    /**
     * 递归将「数学上为整数」的 float 转为 int（不修改调用方传入的数组，返回新树）
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    private function normalizeIntegralTree(array $params): array
    {
        $out = [];
        foreach ($params as $k => $v) {
            $out[$k] = $this->normalizeIntegralValue($v);
        }

        return $out;
    }

    /**
     * @param mixed $v
     * @return mixed
     */
    private function normalizeIntegralValue($v)
    {
        if (is_array($v)) {
            $next = [];
            foreach ($v as $k => $item) {
                $next[$k] = $this->normalizeIntegralValue($item);
            }

            return $next;
        }
        if (is_float($v) && is_finite($v) && $v == floor($v) && $v >= PHP_INT_MIN && $v <= PHP_INT_MAX) {
            return (int) $v;
        }

        return $v;
    }

    /**
     * 递归排序数组的 Keys
     *
     * @param mixed $obj 要排序的对象
     * @return mixed 排序后的对象
     */
    private function sortArrayKeys($obj)
    {
        if (is_array($obj)) {
            ksort($obj);
            foreach ($obj as $key => $value) {
                $obj[$key] = $this->sortArrayKeys($value);
            }

            return $obj;
        }

        return $obj;
    }
}
