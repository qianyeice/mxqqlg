<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 13:24
 */

namespace app\api\model;

use think\Model;

class Commodity extends Model
{
    /**
     * 得到首页所有商品
     * 龙云飞
     * @return array
     */
    public function getCommData()
    {
        $data = [
            "shangpinid" => "商品id",
            "shangpinming" => "商品名",
            "IMG" => "商品图片地址",
            "jiage" => 998,
            "shnagpinleixing" => "商品类型",
            "shangpinchandi" => "四川成都",
        ];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'notuser';
            $array["data"] = "null";
        }
        return $array;
    }

    /**
     *得到商品详情
     * 龙云飞
     * @return array
     */
    public function getCommodityDetails($spuId,$huodongId)
    {
        $data = [
            "sp_name" => "商品名",
            "lunbo_img" => "轮播图",
            "sp_amount" => 998,//商品价格
            "sell_sum" => 100,//商品销量
            "sp_sum" => 999, //商品库存
            "review" => 200,  //评论条数
            "sp_detail" => "详情描述",
            "sp_norm" => "规格",
            "sp_isactivity"=>1     //是否是活动商品 1是，0不是
        ];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'notuser';
            $array["data"] = "没有查询到商品";
        }
        return $array;
    }
}