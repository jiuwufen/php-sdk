<?php

namespace JiuWuFen\Sdk\Exception;

use Exception;

/**
 * API 异常类
 *
 * @package JiuWuFen\Sdk\Exception
 */
class ApiException extends Exception
{
    /**
     * @var int 错误码
     */
    private int $code;

    /**
     * @var string 错误信息
     */
    private string $errorMessage;

    /**
     * @var string 请求 ID
     */
    private string $reqId;

    /**
     * 构造函数
     *
     * @param int $code 错误码（-1: 网络错误，0: 成功，>0: 业务错误）
     * @param string $message 错误信息
     * @param string $reqId 请求 ID
     */
    public function __construct(int $code, string $message, string $reqId = '')
    {
        $this->code = $code;
        $this->errorMessage = $message;
        $this->reqId = $reqId;

        $formattedMessage = $this->formatMessage();
        parent::__construct($formattedMessage, $code);
    }

    /**
     * 格式化错误信息
     *
     * @return string
     */
    private function formatMessage(): string
    {
        if (!empty($this->reqId)) {
            return "[{$this->code}] {$this->errorMessage} (req_id: {$this->reqId})";
        }
        return "[{$this->code}] {$this->errorMessage}";
    }

    /**
     * 是否为业务错误
     *
     * @return bool
     */
    public function isBusinessError(): bool
    {
        return $this->code > 0;
    }

    /**
     * 是否为网络错误
     *
     * @return bool
     */
    public function isNetworkError(): bool
    {
        return $this->code === -1;
    }

    /**
     * 获取错误码
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * 获取错误信息
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * 获取请求 ID
     *
     * @return string
     */
    public function getReqId(): string
    {
        return $this->reqId;
    }
}
