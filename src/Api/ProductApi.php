<?php

namespace JiuWuFen\Sdk\Api;

use JiuWuFen\Sdk\JiuWuFenClient;
use JiuWuFen\Sdk\Exception\ApiException;

/**
 * Product API
 *
 * @package JiuWuFen\Sdk\Api
 */
class ProductApi
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
     * 定时拉取绑定关系,查询绑定关系,至少时间范围要拉取前一天的。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - end_binding_time (string, 选填): 查询绑定结束时间 (格式: yyyy-MM-dd HH:mm:ss, 最大 7 天)
     *     - merchant_sku_code ([]string, 选填): 商家商品编码数组
     *     - page (int, 选填): 默认 1
     *     - page_size (int, 选填): 默认 20,最大 100
     *     - start_binding_time (string, 选填): 查询绑定开始时间 (格式: yyyy-MM-dd HH:mm:ss, 最大 7 天)
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.list ([]MerchantSkuItem, 必填): Sku 列表
     *         - data.list.bind_time (string, 必填): 绑定时间
     *         - data.list.brand_id (long, 必填): 品牌 ID
     *         - data.list.brand_name (string, 必填): 品牌名称
     *         - data.list.child_category_id (long, 必填): 三级类目 ID
     *         - data.list.child_category_name (string, 必填): 三级类目名称
     *         - data.list.code (string, 必填): 商品货号
     *         - data.list.img (string, 必填): 主图 URL
     *         - data.list.merchant_sku_code (string, 必填): 商家商品编码
     *         - data.list.middle_category_id (long, 必填): 二级类目 ID
     *         - data.list.middle_category_name (string, 必填): 二级类目名称
     *         - data.list.property_value (string, 必填): 销售属性字符串
     *         - data.list.root_category_id (long, 必填): 一级类目 ID
     *         - data.list.root_category_name (string, 必填): 一级类目名称
     *         - data.list.sku_id (long, 必填): 商品 ID
     *         - data.list.sku_properties ([]PropertyItem, 必填): 销售属性数组
     *           - data.list.sku_properties.property_name (string, 必填): 属性名称
     *           - data.list.sku_properties.property_value (string, 必填): 属性值
     *         - data.list.spu_id (long, 必填): SPU ID
     *         - data.list.title (string, 必填): 商品标题
     *       - data.total (long, 必填): 总记录数
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function skuListBinding(array $data = []): array
    {
        return $this->client->request('/api_tob/merchantSkuList/v1.0', $data);
    }

    /**
     * 通用查询,不限制商品绑定。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - brand_id (long, 选填): 品牌 ID
     *     - brand_name (string, 选填): 品牌名称 (精确搜索)
     *     - child_category_id_list ([]long, 必填): 三级类目列表
     *     - code (string, 选填): 货号
     *     - ids ([]long, 选填): SKU ID 列表
     *     - last_id (long, 选填): 最后一条记录 ID (分页游标)
     *     - must_status (long, 选填): 启用状态 (1: 开启, 2: 关闭)
     *     - page (long, 选填): 页码 (默认 1)
     *     - page_size (long, 选填): 每页数量 (默认 100, 最大 100)
     *     - spu_id (long, 选填): SPU ID
     *     - title (string, 选填): SKU 名称
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.list ([]SkuListItem, 必填): 商品列表
     *         - data.list.brand_id (long, 必填): 品牌 ID
     *         - data.list.brand_name (string, 必填): 品牌名称
     *         - data.list.child_category_id (long, 必填): 三级类目 ID
     *         - data.list.child_category_name (string, 必填): 三级类目名称
     *         - data.list.code (string, 必填): 商品货号
     *         - data.list.middle_category_id (long, 必填): 二级类目 ID
     *         - data.list.middle_category_name (string, 必填): 二级类目名称
     *         - data.list.property_value (string, 必填): 销售属性字符串 (如: 颜色-红, 尺码-XL)
     *         - data.list.root_category_id (long, 必填): 一级类目 ID
     *         - data.list.root_category_name (string, 必填): 一级类目名称
     *         - data.list.sku_id (long, 必填): SKU ID
     *         - data.list.sku_properties ([]PropertyItem, 必填): 销售属性详情
     *           - data.list.sku_properties.property_name (string, 必填): 属性名
     *           - data.list.sku_properties.property_value (string, 必填): 属性值
     *         - data.list.spu_id (long, 必填): SPU ID
     *         - data.list.spu_source (string, 必填): SPU 来源 (如: 得物同步、95分自建)
     *         - data.list.spu_src_orig (string, 必填): SPU 原始来源 (如: es)
     *         - data.list.title (string, 必填): 商品标题
     *       - data.total (long, 必填): 总数
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function skuListGeneral(array $data = []): array
    {
        return $this->client->request('/api_tob/skuList/v1.0', $data);
    }

    /**
     * 新增商品接口。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - brand_id (long, 必填): 品牌 ID (详见可鉴品牌查询接口)
     *     - code (string, 选填): 货号 (长度 < 64)
     *     - first_img (string, 必填): 商品首图
     *     - fit_id (int, 选填): 适合人群 (1=通用, 2=男, 3=女, 4=儿童, 5=婴童, 6=中童, 7=大童; 默认 1)
     *     - flaw_desc (string, 选填): 瑕疵信息 (长度 < 64)
     *     - flaw_imgs ([]string, 选填): 瑕疵图
     *     - general_imgs ([]string, 必填): 概况图 (2~15张, 根据类目不同要求不同)
     *     - goods_sn (string, 必填): 商品编号 (长度 5~128)
     *     - l1_category_id (long, 必填): 一级类目 ID
     *     - l2_category_id (long, 选填): 叶子类目 ID (三级类目)
     *     - parts (string, 选填): 配件 (长度 < 32)
     *     - price (int, 必填): 售价
     *     - property_list ([]object, 选填): 属性列表 (详见获取类目属性接口)
     *       - property_list.id (long, 必填): 属性 ID
     *       - property_list.name (string, 必填): 属性名称
     *       - property_list.property_type (int, 必填): 属性类别 (0: 销售属性, 1: 基础属性)
     *       - property_list.value (string, 必填): 属性值 (多个英文逗号分割)
     *     - quality (int, 选填): 成色
     *     - remark (string, 选填): 备注 (长度 < 64)
     *     - size (string, 选填): 尺码 (长度 < 128)
     *     - support_bargain (int, 选填): 是否开启还价 (0: 不开启, 1: 开启)
     *     - title (string, 选填): 商品标题 (长度 < 128)
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 数据
     *     - msg (string, 必填): 消息
     *     - status (int, 必填): 状态码
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function addOrderGoods(array $data = []): array
    {
        return $this->client->request('/api_tob/addOrderGoods/v1.0', $data);
    }

    /**
     * 查询商品的上架状态及详情链接。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 必填): 商品唯一码
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.channel_sku_url (string, 必填): 商品详情 H5 URL
     *       - data.status (int, 必填): 商品状态 (1:待上架, 2:出售中, 3:已售出, 4:已下架, 5:已下单)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function goodsInfo(array $data = []): array
    {
        return $this->client->request('/api_tob/goodsInfo/v1.0', $data);
    }

    /**
     * 改价
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 必填): 三方商品唯一标识
     *     - price (long, 必填): 售价 (元)
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 返回的数据
     *     - msg (string, 必填): 描述
     *     - req_id (string, 必填): 请求id
     *     - status (int, 必填): 处理成功或失败的状态码(成功时值为 0)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function updatePrice(array $data = []): array
    {
        return $this->client->request('/api_tob/updatePrice/v1.0', $data);
    }

    /**
     * 下架商品
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 必填): 三方商品唯一标识
     *     - type (int, 选填): 枚举:1 为后验强制下架 (仅 3C 寄售后验商品传 1)
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 返回的数据
     *     - msg (string, 必填): 描述
     *     - req_id (string, 必填): 请求id
     *     - status (int, 必填): 处理成功或失败的状态码(成功时值为 0)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function cancelOrder(array $data = []): array
    {
        return $this->client->request('/api_tob/cancelOrder/v1.0', $data);
    }

    /**
     * 卖家议价 (UpdateSellerBargain)
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 必填): 第三方商品编号 (最大长度 128)
     *     - price (int, 必填): 议价价格 (单位: 元,必须以 9 结尾)
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
    public function updateSellerBargain(array $data = []): array
    {
        return $this->client->request('/api_tob/updateSellerBargain/v1.0', $data);
    }

    /**
     * 卖家接受还价 (BargainSuccess)
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 必填): 第三方商品编号 (最大长度 128)
     *     - price (int, 必填): 买家还价最大价格 (单位: 元,必须以 9 结尾)
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
    public function bargainSuccess(array $data = []): array
    {
        return $this->client->request('/api_tob/bargainSuccess/v1.0', $data);
    }

    /**
     * 通过叶子类目 ID 获取 95 分该类目下具体的销售属性列表。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - child_category_id (int, 必填): 叶子类目 ID (三级类目)
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 返回的数据
     *       - data.list ([]PropertyItem, 必填): 属性列表
     *         - data.list.id (int, 必填): 属性 ID
     *         - data.list.is_required (int, 必填): 是否必填 (0: 非必填, 1: 必填)
     *         - data.list.name (string, 必填): 属性名称
     *         - data.list.property_type (int, 必填): 属性类别 (0: 销售属性, 1: 基础属性)
     *         - data.list.value_options (string, 必填): 属性值 (英文逗号分割)
     *     - msg (string, 必填): 描述
     *     - req_id (string, 必填): 请求 ID
     *     - status (int, 必填): 处理成功或失败的状态码 (成功时值为 0)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function queryProperties(array $data = []): array
    {
        return $this->client->request('/api_tob/query_properties/v1.0', $data);
    }

    /**
     * 通过一级类目 ID 和品牌名称获取 95 分可鉴品牌列表,返回前 100 个符合条件的品牌信息。支持模糊查询。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - brand_name (string, 必填): 品牌名称 (支持模糊查询)
     *     - l1_category_id (int, 必填): 一级类目 ID
     *     - l2_category_id (int, 选填): 二级类目 ID
     *
     * 响应字段（树状层级，对照文档）:
     *     - data (object, 必填): 返回的数据
     *       - data.list ([]BrandIdentifyItem, 必填): 支持鉴别的品牌列表
     *         - data.list.id (int, 必填): 品牌 ID
     *         - data.list.name (string, 必填): 品牌名称
     *     - msg (string, 必填): 描述
     *     - req_id (string, 必填): 请求 ID
     *     - status (int, 必填): 处理成功或失败的状态码 (成功时值为 0)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function getBrandIdentifyAbility(array $data = []): array
    {
        return $this->client->request('/api_tob/get_brand_identify_ability/v1.0', $data);
    }

    /**
     * 复制订单上架 (CopyOnSale)
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - new_goods_sn (string, 必填): 新 goods_sn
     *     - old_goods_sn (string, 必填): 原 goods_sn
     *     - price (int, 必填): 价格 (单位: 元)
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
    public function copyOnSale(array $data = []): array
    {
        return $this->client->request('/api_tob/copyOnSale/v1.0', $data);
    }

    /**
     * 查询参考价格,包含平台最低价、寄售最低价、最近成交均价、全新市场价、平台限价(3C专属,为最高出价限制)。
     *
     * 请求体字段（树状层级，与文档点分路径一致）:
     *     - goods_sn (string, 必填): 三方商品唯一标识 (与 order_number, sku_id+is_new+sale_type 三选一)
     *     - is_new (long, 选填): 成色
     *     - order_number (string, 必填): 卖家订单号
     *     - sale_type (long, 选填): 出售方式 (固定传 3)
     *     - sku_id (long, 选填): skuId
     *
     * 响应字段（树状层级，对照文档）:
     *       - data.consign_min_price (int, 必填): 寄售最低价 (单位: 分)
     *       - data.new_market_price (int, 必填): 全新市场价 (单位: 分)
     *       - data.platform_max_price (int, 必填): 平台限价 (3C专属, 单位: 分)
     *       - data.platform_min_price (int, 必填): 平台最低价 (单位: 分)
     *       - data.recent_trans_price (int, 必填): 最近成交均价 (单位: 分)
     *
     * @param array $data 完整请求体（须包含各层级嵌套结构）
     * @return array 响应数据
     * @throws ApiException
     */
    public function referencePrice(array $data = []): array
    {
        return $this->client->request('/api_tob/referencePrice/v1.0', $data);
    }
}
