<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Order API
 *
 * @package JiuWuFen\Sdk\Api
 */
class OrderApi
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
     * 查询商品的寄售订单详情。注意:goods_sn、upc、order_number、batch_number 必传其中一个。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - batch_number (string, 选填): 批次号
     *     - goods_sn (string, 选填): Goods_sn
     *     - is_fee_detail (int, 选填): 是否查询服务费 (0: 否, 1: 是)
     *     - is_retrieve (int, 选填): 是否查询取回费 (0: 否, 1: 是)
     *     - order_number ([]string, 选填): 95 卖家订单号
     *     - page (long, 选填): 页码 (默认 1)
     *     - page_size (long, 选填): 每页个数 (默认 20, 最大 20)
     *     - upc (string, 选填): 商品统一代码
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.order_list ([]OrderItem, 必填): 订单列表
     *         - data.order_list.batch_number (string, 必填): 批次号
     *         - data.order_list.bill_price (int, 必填): 结算金额 (分)
     *         - data.order_list.buyer_create_time (string, 必填): 买家创建时间
     *         - data.order_list.buyer_order_number (string, 必填): 买家订单号
     *         - data.order_list.buyer_pay_time (string, 必填): 买家支付时间
     *         - data.order_list.buyer_price (int, 必填): 买家成交价
     *         - data.order_list.fee_detail (object, 必填): 服务费明细
     *           - data.order_list.fee_detail.is_activity (int, 必填): 是否活动
     *           - data.order_list.fee_detail.total_fees (int, 必填): 总服务费
     *         - data.order_list.final_price (int, 必填): 预计收入 (分)
     *         - data.order_list.flaw_list ([]FlawItem, 必填): 瑕疵列表
     *           - data.order_list.flaw_list.desc (string, 必填): 瑕疵描述
     *           - data.order_list.flaw_list.img (string, 必填): 瑕疵图
     *         - data.order_list.free_ship_info (object, 必填): 包邮补贴信息
     *           - data.order_list.free_ship_info.allowance_price (int, 必填): 平台补贴金额
     *           - data.order_list.free_ship_info.origin_freight (int, 必填): 原始邮费
     *           - data.order_list.free_ship_info.seller_freight_price (int, 必填): 卖家承担金额
     *         - data.order_list.free_shipping_amount (int, 必填): 包邮分摊优惠券金额 (分)
     *         - data.order_list.full_reduction_amount (int, 必填): 满减分摊优惠券金额 (分)
     *         - data.order_list.goods_info (object, 必填): 商品信息
     *           - data.order_list.goods_info.brand_name (string, 必填): 品牌
     *           - data.order_list.goods_info.child_category_name (string, 必填): 二级类目名称
     *           - data.order_list.goods_info.img (string, 必填): 商品主图
     *           - data.order_list.goods_info.property_value (string, 必填): 销售属性字符串
     *           - data.order_list.goods_info.quality (string, 必填): 成色
     *           - data.order_list.goods_info.root_category_name (string, 必填): 一级类目名称
     *           - data.order_list.goods_info.size (string, 必填): 货号
     *           - data.order_list.goods_info.status (int, 必填): 商品状态 (1:待上架, 2:出售中, 3:已售出, 4:已下架)
     *           - data.order_list.goods_info.title (string, 必填): 商品名称
     *         - data.order_list.goods_sn (string, 必填): goods_sn
     *         - data.order_list.imei (string, 必填): IMEI
     *         - data.order_list.img_list ([]string, 必填): 图片信息 (展示图+瑕疵图)
     *         - data.order_list.is_free_ship (int, 必填): 是否包邮 (1:是, 0:否)
     *         - data.order_list.is_posterior (bool, 必填): 是否后验
     *         - data.order_list.posterior_status (int, 必填): 后验单状态
     *         - data.order_list.price (int, 必填): 出价 (分)
     *         - data.order_list.promotion_info_list ([]PromotionInfo, 必填): 优惠券列表明细
     *         - data.order_list.publish_time (string, 必填): 上架时间
     *         - data.order_list.retrieve_price (int, 必填): 取回费用 (分)
     *         - data.order_list.sell_order_number (string, 必填): 95 卖家订单号
     *         - data.order_list.seller_coupon_amount (int, 必填): 卖家分摊优惠券金额 (分)
     *         - data.order_list.sku_min_price (int, 必填): 在售最低价 (分)
     *         - data.order_list.status (int, 必填): 一级状态码
     *         - data.order_list.status_desc (string, 必填): 状态描述
     *         - data.order_list.sub_status (int, 必填): 二级状态码
     *         - data.order_list.total_fees (int, 必填): 服务费
     *         - data.order_list.upc (string, 必填): 商品统一代码
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function consignOrderInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/consignOrderInfo/v1.0', $data);
    }

    /**
     * 获取买家详细收货地址 (加密)。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - order_number (string, 必填): 卖家订单号
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.address (string, 必填): 加密地址字符串 (AES-ECB 解密)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function buyerAddress(array $data = []): array
    {
        return $this->client->request('/api_tob/order/buyerAddress', $data);
    }

    /**
     * 查询自送货批次下的订单明细及查验结果。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - mother_no (string, 必填): 自送单母单批次号
     *     - page (int, 选填): 页码 (默认 1)
     *     - page_size (int, 选填): 每页数量 (默认 20, 最大 100)
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.mother_no (string, 必填): 母单批次号
     *       - data.order_list ([]OrderItem, 必填): 订单列表
     *         - data.order_list.merchant_sku_code (string, 必填): 商家商品编码
     *         - data.order_list.sell_order_number (string, 必填): 95 分卖家订单号
     *         - data.order_list.verification_failure_image_url ([]string, 必填): 查验不通过图片数组
     *         - data.order_list.verification_failure_reason (string, 必填): 查验不通过原因
     *         - data.order_list.verification_result (int, 必填): 查验结果 (1: 待查验, 2: 查验通过, 3: 查验不通过)
     *         - data.order_list.verification_time (long, 必填): 查验时间 (时间戳)
     *       - data.pending_order_count (int, 必填): 待查验订单数量
     *       - data.total_order_count (int, 必填): 订单总数量
     *       - data.unverified_order_count (int, 必填): 查验不通过订单数量
     *       - data.verified_order_count (int, 必填): 查验通过订单数量
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function consignBatchOrderList(array $data = []): array
    {
        return $this->client->request('/api_tob/consignBatchOrderList/v1.0', $data);
    }

    /**
     * 获取挂售订单列表。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn_list ([]string, 必填): goodsSn 数组 (最大不超过 20)
     *
     * 响应字段（树状层级，对照文档）:
     *     - data ([]HangSaleGetOrderListItem, 必填): 订单列表
     *       - data.address_info (object, 必填): 地址信息
     *         - data.address_info.city (string, 必填): 城市
     *         - data.address_info.county (string, 必填): 区县
     *         - data.address_info.mobile (string, 必填): 手机号
     *         - data.address_info.name (string, 必填): 姓名
     *         - data.address_info.postcode (string, 必填): 邮编
     *         - data.address_info.province (string, 必填): 省份
     *         - data.address_info.region (string, 必填): 地区
     *         - data.address_info.street (string, 必填): 街道
     *       - data.buyer_info (object, 必填): 买家信息
     *         - data.buyer_info.buyer_order_number (string, 必填): 买家订单号
     *         - data.buyer_info.order_number (string, 必填): 订单号
     *         - data.buyer_info.pay_time (string, 必填): 支付时间
     *       - data.goods_info (object, 必填): 商品信息
     *         - data.goods_info.audit_status (int, 必填): 审核状态
     *         - data.goods_info.brand_id (int, 必填): 品牌 ID
     *         - data.goods_info.brand_name (string, 必填): 品牌名称
     *         - data.goods_info.code (string, 必填): 货号
     *         - data.goods_info.desc (string, 必填): 描述
     *         - data.goods_info.goods_sn (string, 必填): 商品 SN
     *         - data.goods_info.order_status (string, 必填): 订单状态
     *         - data.goods_info.price (string, 必填): 价格
     *         - data.goods_info.size (string, 必填): 尺码
     *         - data.goods_info.status (int, 必填): 状态
     *         - data.goods_info.stock (int, 必填): 库存
     *         - data.goods_info.title (string, 必填): 标题
     *       - data.goods_sn (string, 必填): 商品 SN
     *       - data.sell_order_number (string, 必填): 卖家订单号
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function getOrderList(array $data = []): array
    {
        return $this->client->request('/api_tob/getOrderList/v1.0', $data);
    }

    /**
     * 查询直发订单列表。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - end_update (string, 选填): 查询更新结束时间 (格式: 2024-10-01 00:00:00)
     *     - express_number (string, 选填): 发货运单号
     *     - is_delivery_late (bool, 选填): 是否发货超时
     *     - is_delivery_timeout_imminent (bool, 选填): 是否临近发货超时
     *     - is_fee_detail (int, 选填): 是否查询服务费 (默认 0)
     *     - merchant_sku_code (string, 选填): 商家商品编码
     *     - order_number ([]string, 选填): 卖家订单号数组
     *     - page (int, 选填): 页码 (默认 1)
     *     - page_size (int, 选填): 每页数量 (默认 20, 最大 100)
     *     - start_update (string, 选填): 查询更新开始时间 (格式: 2024-10-01 00:00:00)
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.list ([]MerchantOrderInfoItem, 必填): 订单列表
     *         - data.list.batch_number (string, 必填): 批次号
     *         - data.list.buyer_address (string, 必填): 买家地址
     *         - data.list.buyer_detail_address (string, 必填): 买家详细地址
     *         - data.list.buyer_name (string, 必填): 买家姓名
     *         - data.list.buyer_order_pay_time (string, 必填): 买家订单支付时间
     *         - data.list.buyer_order_time (string, 必填): 买家下单时间
     *         - data.list.buyer_phone (string, 必填): 买家电话
     *         - data.list.buyer_price (long, 必填): 买家成交价
     *         - data.list.delivery_deadline (string, 必填): 发货截止时间
     *         - data.list.delivery_express_company (string, 必填): 发货承运商
     *         - data.list.delivery_express_number (string, 必填): 发货快递单号
     *         - data.list.delivery_time (string, 必填): 发货时间
     *         - data.list.delivery_type (long, 必填): 发货类型
     *         - data.list.deposit (string, 必填): 保证金金额
     *         - data.list.fee_detail (object, 必填): 服务费明细
     *           - data.list.fee_detail.total_fees (long, 必填): 总服务费
     *         - data.list.final_price (long, 必填): 预计收入 (分)
     *         - data.list.flaw_list ([]FlawItem, 必填): 瑕疵点
     *           - data.list.flaw_list.desc (string, 必填): 瑕疵描述
     *           - data.list.flaw_list.img (string, 必填): 瑕疵图
     *         - data.list.free_ship_info (object, 必填): 包邮补贴信息
     *         - data.list.free_shipping_amount (long, 必填): 包邮分摊优惠券金额
     *         - data.list.full_reduction_amount (long, 必填): 满减分摊优惠券金额
     *         - data.list.goods_info (object, 必填): 商品信息
     *           - data.list.goods_info.brand_name (string, 必填): 品牌
     *           - data.list.goods_info.child_category_name (string, 必填): 二级类目名称
     *           - data.list.goods_info.img (string, 必填): 商品主图
     *           - data.list.goods_info.quality (string, 必填): 成色
     *           - data.list.goods_info.root_category_name (string, 必填): 一级类目名称
     *           - data.list.goods_info.size (string, 必填): 货号
     *           - data.list.goods_info.specification (string, 必填): 销售属性字符串
     *           - data.list.goods_info.status (long, 必填): 商品状态
     *           - data.list.goods_info.title (string, 必填): 商品名称
     *         - data.list.goods_sn (string, 必填): goods_sn
     *         - data.list.imei (string, 必填): imei
     *         - data.list.img_list ([]string, 必填): 图片信息
     *         - data.list.is_delivery (bool, 必填): 是否发货
     *         - data.list.is_free_ship (long, 必填): 是否包邮
     *         - data.list.is_margin_deposit (long, 必填): 是否扣除保证金
     *         - data.list.is_posterior (bool, 必填): 是否后验
     *         - data.list.merchant_sku_code (string, 必填): 商家商品编码
     *         - data.list.posterior_status (long, 必填): 后验单状态
     *         - data.list.price (long, 必填): 出价 (分)
     *         - data.list.publish_time (string, 必填): 上架时间
     *         - data.list.retrieve_price (long, 必填): 取回费用 (分)
     *         - data.list.sell_order_number (string, 必填): 95卖家订单号
     *         - data.list.seller_address (string, 必填): 卖家地址
     *         - data.list.seller_coupon_amount (long, 必填): 卖家分摊优惠券金额
     *         - data.list.seller_order_create_time (string, 必填): 卖家订单创建时间
     *         - data.list.sku_id (long, 必填): 95SkuId
     *         - data.list.sku_min_price (long, 必填): 在售最低价 (分)
     *         - data.list.status (long, 必填): 一级状态码
     *         - data.list.status_desc (string, 必填): 状态描述
     *         - data.list.sub_status (long, 必填): 二级状态码
     *         - data.list.upc (string, 必填): 商品统一代码
     *       - data.total (long, 必填): 总记录数
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function merchantOrderInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/merchantOrderInfo/v1.0', $data);
    }
}
