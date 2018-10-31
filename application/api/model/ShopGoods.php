<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 11:19
 */
namespace app\api\model;
use think\Db;
use think\Model;

class  ShopGoods extends Model{
    /**
     * 购物车页面商品
     * 程建 2018-3-27 11:47
     * @param $id用户id
     * @return array 返回购物车商品
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function shop_cart($id){
      $data=$this->where('user_id',$id)->select();
//        $data = Db::table("shop")->alias("s")->join("goods_sku gs","s.sku_id=gs.spu_Id")->join("goods_spu sp","s.sku_id=sp.id")
//            ->where("member_id",$id)->field("s.number as shopnumber,gs.sku_name,gs.spec,gs.thumb,gs.number,gs.market_price,sp.name")->select();
//        $array=array();



//        判定是否有数据
        if(count($data)>0){
//            计算今日总积分
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;

        return $array;
    }


    function shop_carts($id){
        $data=Db::table('shop_goods_fc')->where('user_id',$id)->select();
//        $data = Db::table("shop")->alias("s")->join("goods_sku gs","s.sku_id=gs.spu_Id")->join("goods_spu sp","s.sku_id=sp.id")
//            ->where("member_id",$id)->field("s.number as shopnumber,gs.sku_name,gs.spec,gs.thumb,gs.number,gs.market_price,sp.name")->select();
//        $array=array();



//        判定是否有数据
        if(count($data)>0){
//            计算今日总积分
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;

        return $array;
    }

    public function shopCar($memberId){

        $data=[
            "comm_name"=> "商品名",
            "comm_img"=> "商品图",
            "comm_amount"=>  "价格",
            "comm_norm"=> "商品规格",
            "comm_sum"=> "商品数量",
        ];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"]=$data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'notdata';
        }
        return $array;

    }
}