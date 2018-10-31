<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/20
 * Time: 12:23
 */

namespace app\api\model;

use think\Db;
use think\Model;

class GoodsSpu extends Model
{

    /**
     * 商品详情
     * 岳军章
     * 2018-3-20 15：30
     * @param $id 商品ID $sql
     * @param $array 返回参数
     * @return array|null|\PDOStatement|string|Model 返回商品信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function goods_show($id)
    {

        $sql = Db::table('goods_spu')->where('id', $id)->field("id,name,sn,content,shop_price,market_price,imgs,thumb,status,Sales_volume")->select();
        $sql1 = Db::table('goods_sku')->where('spu_id', $id)->field("sku_name,spec,number,show_in_lists")->select();
        $res = Db::table('evaluation')->where('spu_id', $id)->count();


        if (!$sql1) {
            $sql['number'] = 0;
        } else {
            $sql[0]['number'] = $sql1[0]['number'];
            $sql[0]['spec'] = $sql1[0]['spec'];
            $sql[0]['sku_name'] = $sql1[0]['sku_name'];
        }

        $sql[0]['eva_num'] = $res;

        //判断返回数据
        $array = array();
        if (count($sql) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $sql;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;
    }


    public function test($id)
    {
        $test = Db::table("goods_spu")->alias("gs")
            ->join("goods_sku gk", "gs.id=gk.spu_id")
            ->where("gs.id", $id)
            ->field("gs.id,gk.id as gk_id,gs.name,gs.sn,gs.catid,gs.brand_id,gs.content,gs.shop_price,gs.market_price,gk.market_price as spu_mark,gk.shop_price as spu_shop,gs.imgs,gs.thumb,gs.video_img,gs.video,gs.status,gs.delivery_template_id,gs.type,gs.Sales_volume,gs.is_special,gs.notice,gs.weight,gs.volume,gs.detail,sku_name,spec,number,show_in_lists,up_time,update_time,fencheng,gk.thumb as sku_thu")
            ->select();

        $res = Db::table('evaluation')->where('spu_id', $id)->count();

        $test[0]['eva_num'] = $res;
        $array = array();
        if (count($test) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $test;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;
    }

    public function toFlash($rush,$id)
    {
        $res = Db::table("goods_sku")->alias("gs")
            ->join("goods_spu gp", "gs.spu_id = gp.id")
            ->join("promotion_commodity_relation pc", "gs.id = pc.spu_id")
            ->where("gp.id", $id)
            ->where("pc.Promotion_commodity_id",$rush)
            ->field("gp.name,gp.content,gp.Sales_volume,pc.spu_surplus_number as number,pc.spu_price,gs.id as gk_id,gs.sku_name,gs.spec,gs.thumb")
            ->select();

        $ev_num = Db::table('evaluation')->where('spu_id', $id)->count();

        $receive = array();
        $real = array();
        if (count($res) > 0) {
            $res[0]['eva_num'] = $ev_num;
            $real[0] = $res[0];
            $receive['type'] = 1;
            $receive['lang'] = "success";
            $receive['data'] = $real;
        } else {
            $receive['type'] = 0;
            $receive['lang'] = "error";
            $receive['data'] = "";
        }
        return $receive;
    }


    /**
     * 判断商品类型
     * 程建
     * 18-3-20 17:10
     * @param $id 传入商品ID
     * @return array|null|\PDOStatement|string|Model 返回商品信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function judge($id)
    {
        $data = $this->field('type')->where('id', $id)->find();
        if (count($data) > 0) {
            return ['type' => 1, 'data' => $data->toArray(), 'lang' => lang('yesRefund')];
        } else {
            return ['type' => 0, 'data' => '', 'lang' => 'noRefund'];
        }
    }

    /**
     * time：18-3-20 16:54
     * author:陈明福
     * 根据销售类型查询对应的销售商品
     * @param $type 销售类型
     * @return mixed 检测查询数据并返回返回
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsType()
    {
        $data = Db::name('goods_spu-category')->field("id,name,sn,catid,brand_id,content,market_price,imgs,thumb,video_img,video,status,delivery_template_id,type,Sales_volume,detail,catename,skuprice,skuid")
//            ->cache("goodsType{$type}",7200)
            ->cache(7200)->select();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['catename'] = mb_substr($data[$i]['catename'], 0, -1, "UTF-8");
        }
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;
    }

    /**
     * 新人商品详情
     * 陈昌海
     * 18.03.20 16:20
     * @param $id 传入商品ID
     * @return  $shop 返回商品信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function nowsgoods($id)
    {
        $shop = $this
            ->field('id,name,sn,content,shop_price,market_price,imgs,thumb,detail,video_img,video')
            ->where(['type' => '1', 'id' => $id])
            ->find();
//        return  DataContentJudgment($shop);//修改的返回值
        $array = array();
        if (count($shop) > 0) {
            $array["type"] = 1;
            $array["lang"] = "success";
            $array["data"] = $shop;
        } else {
            $array["type"] = 0;
            $array["lang"] = "faileds";
            $array["data"] = count($shop);
        }
        return $array;

    }

    /**
     * 其他商品
     * 丁龙
     * 18.3.20 18:05
     * @param $id 商品ID
     * @return array 状态数据包
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function other($id)
    {
        $cxjg = $this->query('CALL pro_select_rand_five(' . $id . ')');
        $array = array();
        if (count($cxjg) > 0) {
            $array["type"] = 1;
            $array["data"] = $cxjg;
            $array["lang"] = "success";
        } else {
            $array["type"] = 0;
            $array["data"] = '';
            $array["lang"] = "ErroneousGoods";
        }
        return $array;
    }

    /**
     * time：18-3-20 16:54
     * author:陈明福
     * 搜索主商品货号
     * @param $key 主商品货号
     * @return $array 返回数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function numberOfSearch($key)
    {
        $data = $this->field("id,name,sn,catid,brand_id,content,shop_price,market_price,imgs,thumb,delivery_template_id,video,video_img")
            ->where("sn", $key)->where("status", "1")->find();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data->toArray();
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;
    }

    /**
     * 删除商品列表的商品
     * Time: 2018\4\8  11:10
     * name：陈昌海
     */
    function cut($id)
    {
        $table = $this->where('id', $id)->update(['status' => '-1']);

        $array = [];
        if (count($table) != -1) {
            $array["lang"] = lang('delete_faileds');
        } else {
            $array["lang"] = lang('success');
        }
        return $array;
    }

    /**
     * 商品详情轮播图
     * Time: 2018\4\8  11:10
     * name：陈健英
     */
    public function lun($id)
    {
        $lun = $this->where('id', $id)->field('imgs')->select();
        $array = [];
        if ($lun) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $lun;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'fail';
            $array["data"] = $lun;
        }
        return $array;

    }

    public function area($key)
    {
        $data = Db::name("goods_spu")->where('type', $key)->select();
        $array = array();
        if (isset($data[0]["type"])) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noGoods');
            $array["data"] = '';
        }
        return $array;
    }

    public function nperson($id)
    {
        $data = Db::name('order')->field("count('id')")->where('buyer_id', $id)->select();
        $array = array();
        if(count($data) > 0){
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $data;
        }else{
            $array["type"] = 0;
            $array["lang"] = lang('faileds');
            $array["data"] = '';
        }
        return $array;
    }

    /**
     * 邓强
     * 提交订单多商品的法法师法师法
     */
    public function Multi_commodity($id, $gid){

        //此处循环查询，数据返回不正确.老易更改(第二句join)12
        $a = [];
        for ($i = 0; $i < count($id); $i++) {
         $data  = Db::table('shop')
            ->join('goods_sku','shop.sku_id=goods_sku.id')
            ->where('shop.id',$gid[$i])
            ->field("goods_sku.sku_name,goods_sku.spec,goods_sku.shop_price,goods_sku.thumb,shop.number,shop.fc_type")
            ->select();
        $a[]=$data;
    }
    $array = array();
        if (count($a) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $a;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;



  }

//    /**
//     * 邓强
//     * 查询购物车id 数量
//     * @param $id 参数
//     * @return array 返回结果集
//     *
//     */
//    public function Multi_shop($id)
//    {
//        $a = [];
//        for ($i = 0; $i < count($id); $i++) {
////查询id 数量
//            //判断返回数据
//            array_push($a, $sql);
//
//        }
//        $array = array();
//        if (count($a) > 0) {
//            $array["type"] = 1;
//            $array["lang"] = 'success';
//            $array["data"] = $a;
//        } else {
//            $array["type"] = 0;
//            $array["lang"] = 'noData';
//            $array["data"] = '';
//        }
//        return $array;
//    }

    public function spec_Price($id)
    {
        $data = Db::table('goods_sku')
            ->where('id', $id)
            ->field("goods_sku.sku_name,goods_sku.spec,goods_sku.shop_price,goods_sku.thumb")
            ->select();
        $array = array();
        if (count($data)>0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noGoods');
            $array["data"] = '';
        }
        return $array;
    }

}