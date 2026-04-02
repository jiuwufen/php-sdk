<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Return API
 *
 * @package JiuWuFen\Sdk\Api
 */
class ReturnApi
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
     * 查询退货订单列表。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - apply_time_end (string, 选填): 退货创建结束时间
     *     - apply_time_start (string, 选填): 退货创建开始时间
     *     - in_express_number (string, 选填): 买家退回快递单号
     *     - last_update_end (string, 选填): 最后更新结束时间
     *     - last_update_start (string, 选填): 最后更新开始时间
     *     - page (long, 选填): 页码 (默认 1)
     *     - page_size (long, 选填): 每页数量 (默认 20)
     *     - refund_number (string, 选填): 退货订单号
     *     - refund_step (long, 选填): 退货阶段
     *     - seller_order_number (string, 选填): 卖家订单号
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.list ([]OrderItem, 必填): 订单列表
     *         - data.list.goods_info (object, 必填): 商品信息
     *           - data.list.goods_info.merchant_sku_code (string, 必填): 商家编码
     *           - data.list.goods_info.sku_id (long, 必填): SKU ID
     *           - data.list.goods_info.title (string, 必填): 商品名称
     *         - data.list.refund_info (object, 必填): 退货相关信息
     *           - data.list.refund_info.apply_reason (string, 必填): 退货原因
     *           - data.list.refund_info.in_express_number (string, 必填): 买家退回快递单号
     *           - data.list.refund_info.refund_step (long, 必填): 退货阶段代码
     *           - data.list.refund_info.step_name (string, 必填): 退货状态描述
     *       - data.total (long, 必填): 总记录数
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundList(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/list/v1.0', $data);
    }

    /**
     * 商家确认签收退货。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - refund_number (string, 必填): 退货订单号
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.result (bool, 必填): 是否成功
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundConfirm(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/confirmReceive', $data);
    }

    /**
     * 查询买家退回的地址 (加密)。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - refund_number (string, 必填): 退货订单号
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.address (string, 必填): 加密地址字符串
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundBuyerAddress(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/backBuyerAddress', $data);
    }

    /**
     * 退货审核不通过时,发货退回给买家。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - refund_number (string, 必填): 退货订单号
     *     - return_express_number (string, 必填): 退回买家运单号
     *     - return_express_type (int, 必填): 退回买家运单类型
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.success (bool, 必填): 是否成功
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundSuccess(array $data = []): array
    {
        return $this->client->request('/api_tob/refund/refundSuccess', $data);
    }

    /**
     * 查询退货订单列表详情。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 选填): 商品唯一标识
     *     - order_number ([]string, 选填): 95 卖家订单号
     *     - page (int, 选填): 页码 (默认 1)
     *     - page_size (int, 选填): 每页数量 (默认 20, 最大 20)
     *     - refund_time (string, 选填): 创建退货订单时间 (默认最近一年, 格式: yyyy-MM-dd~yyyy-MM-dd)
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.order_list ([]RefundOrderInfoItem, 必填): 订单商品列表 (最大 20)
     *         - data.order_list.buyer_pay_time (string, 必填): 买家支付时间
     *         - data.order_list.goods_belong (int, 必填): 商品流向
     *         - data.order_list.goods_info (object, 必填): 商品信息
     *         - data.order_list.goods_sn (string, 必填): 商品唯一标识
     *         - data.order_list.imei (string, 必填): 设备唯一标识
     *         - data.order_list.into_time (string, 必填): 退货入仓时间
     *         - data.order_list.is_post_inspection_order (string, 必填): 是否后验订单 (是; 否)
     *         - data.order_list.price (int, 必填): 买家成交金额 (分)
     *         - data.order_list.refund_confirm_time (string, 必填): 退款时间
     *         - data.order_list.refund_determine_time (string, 必填): 判责时间
     *         - data.order_list.refund_order_status (int, 必填): 退货订单状态
     *         - data.order_list.refund_price (int, 必填): 退款金额 (分)
     *         - data.order_list.refund_reason_type_desc (string, 必填): 售后类型
     *         - data.order_list.refund_seller_express_number (string, 必填): 退货运单号
     *         - data.order_list.refund_time (string, 必填): 发起退货时间
     *         - data.order_list.remark (string, 必填): 判责原因
     *         - data.order_list.root_determine_option_name (string, 必填): 判责结果
     *         - data.order_list.root_determine_types (int, 必填): 判责责任方
     *         - data.order_list.sell_order_number (string, 必填): 95 分卖家订单号
     *         - data.order_list.sell_order_status (string, 必填): 卖家订单状态
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function refundOrderInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/refundOrderInfo/v1.0', $data);
    }
}
