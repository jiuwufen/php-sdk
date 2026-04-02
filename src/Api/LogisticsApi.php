<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Logistics API
 *
 * @package JiuWuFen\Sdk\Api
 */
class LogisticsApi
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
     * 商家发货并获取面单信息。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - order_number (string, 必填): 卖家订单号
     *     - send_address (DeliveryAddress, 必填): 卖家发货地址
     *       - send_address.city (string, 必填): 市
     *       - send_address.county (string, 必填): 区/县
     *       - send_address.mobile (string, 必填): 联系方式
     *       - send_address.name (string, 必填): 姓名
     *       - send_address.province (string, 必填): 省
     *       - send_address.street (string, 选填): 街道
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.list ([]PlatformDeliveryResp, 必填): 面单列表
     *         - data.list.address_info (DeliveryAddress, 必填): 地址信息
     *         - data.list.dept_code (string, 必填): 分拣中心
     *         - data.list.dest_route_label (string, 必填): 路由三段码
     *         - data.list.dimension_code (string, 必填): 顺丰面单二维码信息
     *         - data.list.express_name (string, 必填): 承运商名称
     *         - data.list.express_number (string, 必填): 快递单号 (子单号)
     *         - data.list.goods_title (string, 必填): 商品标题
     *         - data.list.order_number (string, 必填): 订单编号
     *         - data.list.two_dimension_code (string, 必填): 二维码序列信息
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function deliveryBiz(array $data = []): array
    {
        return $this->client->request('/api_tob/delivery/bizDelivery/v1.0', $data);
    }

    /**
     * 寄售模式下,商家申请打印面单并发货。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - address (object, 选填): 卖家地址
     *       - address.city (string, 选填): 市
     *       - address.county (string, 选填): 区
     *       - address.mobile (string, 选填): 联系方式
     *       - address.name (string, 选填): 姓名
     *       - address.province (string, 选填): 省
     *       - address.region (string, 选填): 地区 (如: 上海 上海市 杨浦区)
     *       - address.street (string, 选填): 详细地址
     *     - goods_sn (string, 必填): 商品唯一标识
     *     - imei (string, 选填): IMEI
     *     - internal_enterprise_id (string, 选填): 商家内部企业ID
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.address_info (object, 必填): 地址信息
     *         - data.address_info.city (string, 必填): 市
     *         - data.address_info.county (string, 必填): 区
     *         - data.address_info.mobile (string, 必填): 联系方式
     *         - data.address_info.name (string, 必填): 姓名
     *         - data.address_info.province (string, 必填): 省
     *         - data.address_info.street (string, 必填): 详细地址
     *       - data.dept_code (string, 必填): 分拣中心
     *       - data.dest_route_label (string, 必填): 路由三段码
     *       - data.dimension_code (string, 必填): 顺丰面单二维码信息
     *       - data.express_name (string, 必填): 承运商名称
     *       - data.express_number (string, 必填): 快递单号 (子单号)
     *       - data.express_product_type (string, 必填): 快递产品代码
     *       - data.express_type (string, 必填): 承运商类型
     *       - data.generate_time (string, 必填): 快递生成时间
     *       - data.generate_tip (string, 必填): 快递生成区提醒信息
     *       - data.goods_category_name (string, 必填): 类目
     *       - data.origin_express_number (string, 必填): 快递单号 (母单号)
     *       - data.road (string, 必填): 路区
     *       - data.site_name (string, 必填): 站点名称
     *       - data.source_center_name (string, 必填): 来源地分拣中心名称
     *       - data.source_code (string, 必填): 始发滑道号+始发笼车号
     *       - data.target_center_name (string, 必填): 目的分拣中心名称
     *       - data.target_code (string, 必填): 目的滑道号+目的笼车号
     *       - data.two_dimension_code (string, 必填): 二维码全部序列信息
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function consignPlatformDelivery(array $data = []): array
    {
        return $this->client->request('/api_tob/platformDeliver/v1.0', $data);
    }

    /**
     * 发货到平台 (SaveExpressNumber)
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - address (object, 选填): 退回地址 (可选)
     *       - address.city (string, 选填): 市
     *       - address.county (string, 选填): 区
     *       - address.mobile (string, 选填): 联系方式
     *       - address.name (string, 选填): 姓名
     *       - address.province (string, 选填): 省
     *       - address.region (string, 选填): 地区
     *       - address.street (string, 选填): 详细地址
     *     - express_number (string, 必填): 物流单号
     *     - express_type (int, 必填): 快递类型 (1: 顺丰)
     *     - goods_sn (string, 必填): 第三方商品的唯一标识
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 数据
     *     - msg (string, 必填): 返回信息
     *     - status (int, 必填): 状态 (0: 成功, 1: 失败)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function saveExpressNumber(array $data = []): array
    {
        return $this->client->request('/api_tob/saveExpressNumber/v1.0', $data);
    }

    /**
     * 后验模式下,商家申请打印面单并发货。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - address (object, 选填): 卖家发货地址
     *       - address.city (string, 选填): 市
     *       - address.county (string, 选填): 区
     *       - address.mobile (string, 选填): 联系方式
     *       - address.name (string, 选填): 姓名
     *       - address.province (string, 选填): 省
     *       - address.region (string, 选填): 地区
     *       - address.street (string, 选填): 详细地址
     *     - delivery_method (int, 必填): 发货方式 (1:自送货, 2:平台快递, 3:自行发货)
     *     - express_number (string, 选填): 快递单号
     *     - express_type (int, 选填): 承运商类型
     *     - goods_sn_arr ([]string, 必填): 商品唯一标识数组 (上限 100)
     *     - internal_enterprise_id (string, 选填): 商家内部企业ID
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.address_info (object, 必填): 收件人信息
     *         - data.address_info.city (string, 必填): 市
     *         - data.address_info.county (string, 必填): 区
     *         - data.address_info.mobile (string, 必填): 手机号 (脱敏)
     *         - data.address_info.name (string, 必填): 姓名
     *         - data.address_info.province (string, 必填): 省
     *         - data.address_info.street (string, 必填): 街道地址
     *       - data.delivery_method (int, 必填): 发货方式 (1:自送货, 2:平台快递)
     *       - data.express_info (object, 选填): 平台快递信息
     *         - data.express_info.dept_code (string, 必填): 分拣中心
     *         - data.express_info.dest_route_label (string, 选填): 路由三段码
     *         - data.express_info.dimension_code (string, 选填): 顺丰面单二维码信息
     *         - data.express_info.express_name (string, 必填): 承运商名称
     *         - data.express_info.express_number (string, 必填): 快递单号 (子单号)
     *         - data.express_info.express_product_type (string, 选填): 快递产品代码
     *         - data.express_info.express_type (string, 必填): 承运商类型
     *         - data.express_info.generate_tip (string, 选填): 快递生成区提醒信息
     *         - data.express_info.goods_category_name (string, 必填): 商品类目名称
     *         - data.express_info.origin_express_number (string, 选填): 快递单号 (母单号)
     *         - data.express_info.road (string, 选填): 路区
     *         - data.express_info.site_name (string, 选填): 站点名称
     *         - data.express_info.source_center_name (string, 选填): 来源地分拣中心名称
     *         - data.express_info.source_code (string, 选填): 始发滑道号+始发笼车号
     *         - data.express_info.target_center_name (string, 选填): 目的分拣中心名称
     *         - data.express_info.target_code (string, 选填): 目的滑道号+目的笼车号
     *         - data.express_info.two_dimension_code (string, 选填): 二维码全部序列信息
     *       - data.generate_time (string, 必填): 快递生成时间
     *       - data.self_pickup_info (object, 选填): 自送货信息
     *         - data.self_pickup_info.merchant_info (string, 必填): 自送货商家信息
     *         - data.self_pickup_info.self_pickup_number (string, 必填): 自提单号
     *         - data.self_pickup_info.self_pickup_title (string, 必填): 自送货标题
     *       - data.total (int, 必填): 发货数量
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function inspectLogisticsQuery(array $data = []): array
    {
        return $this->client->request('/api_tob/inspectLogisticsQuery/v1.0', $data);
    }

    /**
     * 查询后验仓地址信息。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - rule_id (long, 必填): 后验仓规则id
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.address (object, 必填): 后验仓地址信息
     *         - data.address.city (string, 必填): 市
     *         - data.address.county (string, 必填): 区
     *         - data.address.mobile (string, 必填): 联系方式
     *         - data.address.name (string, 必填): 姓名
     *         - data.address.province (string, 必填): 省
     *         - data.address.region (string, 必填): 地区
     *         - data.address.street (string, 必填): 详细地址
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function postVerificationWarehouseInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/postVerificationWarehouseInfo/v1.0', $data);
    }

    /**
     * 确认发货完成。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - address (address, 选填): 卖家退货仓库地址
     *     - express_number (string, 必填): 发货运单号
     *     - order_number (string, 必填): 卖家订单号
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.result (bool, 必填): 是否成功
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function deliveryConfirm(array $data = []): array
    {
        return $this->client->request('/api_tob/delivery/confirm/v1.0', $data);
    }

    /**
     * 查询运单物流轨迹。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - express_number (string, 必填): 运单号
     *     - is_reverse (bool, 选填): 是否倒序展示
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.items ([]Item, 必填): 物流节点列表
     *         - data.items.desc (string, 必填): 说明
     *         - data.items.location (object, 必填): 位置信息
     *         - data.items.time (string, 必填): 操作时间
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function logisticsQuery(array $data = []): array
    {
        return $this->client->request('/api_tob/logisticsQuery/v1.0', $data);
    }
}
