<?php

namespace app\api\model;

use phpDocumentor\Reflection\Types\Array_;
use think\Db;
use think\Model;
class View_choose extends Model
{
    /**
     * time:28-3-27 17.52
     * name:邓剑
     * @param $id   用户id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //107 我的退款页面判断退货还是退款还是退货并退款
    function chooseRefund($id)
    {
        $data = $this->where('mid', $id)->select();
        if (count($data) >= 1) {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['choose'] == '0') {
                    $data[$i]['data'] = '仅退款';
                } else {
                    $data[$i]['data'] = '退货退款';
                }
            }
            $data['types'] = '1';
            $data['explain'] = lang('yeschoose');
        } else {
            $data = [
                'type' => '0',
                'explain' => lang('nochoose'),
                'data' => count($data)
            ];
        }
        return $data;
    }

    //退款提交接口
    function Refund_application($id,$uid){

        $date=Db::name("order_sku")->where("id",$id)->field("order_id,sku_name,spec,number,img")->select();
        $order_id=$date[0]["order_id"];
        $sku_name=$date[0]["sku_name"];
        $spec=$date[0]["spec"];
        $number=$date[0]["number"];
        $img=$date[0]["img"];
        if($date){
            $ts=[
                "mid"=>$uid,
                "orderid"=>$order_id,
                "goods_name"=>$sku_name,
                "spec"=>$spec,
                "refund_time"=>date("Y-m-d H:i:s",time()),
                "return_number"=>$number,
                "goods_url"=>$img,
            ];
            $res=Db::name("refund")->insert($ts);
            if($res){
                $array = [
                    'type' => '1',
                    'explain' => lang('yesgoodsRefund'),
                    'data' => 1
                ];
            }else{
                $array = [
                    'type' => '0',
                    'explain' => lang('nogoodsRefund'),
                    'data' => 0
                ];
            }
            return $array;

        }

    }


    /**
     * 易婷婷
     * 查看是否已经退款接口
     */
    function tkchankan($id,$order_id){
        $data = Db::name("refund")->where('mid',$id)->where("orderid",$order_id)->select();
        $array=array();
        if($data){
            $array["type"]=1;
            $array["lang"]='error';
            $array["data"]='1';
        }else{
            $array["type"]=0;
            $array["lang"]='error';
            $array["data"]='0';
        }
        return $array;}
}