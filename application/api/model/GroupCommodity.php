<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 16:55
 */
namespace app\api\model;
use think\Model;
use think\Db;
class GroupCommodity extends Model{
    /**
     * 团购详情页面头像，商品详情  差人，
     * 程建 2018-3-27 18:09
     * @param $groupid团购id
     * @param $usrid用户id
     * @return array 返回数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function group_page($groupid){
        $data=$this->field('groupbuy_id,sku_id,join_time,is_leader,end_time,max_num,expires,rules,title,sku_name,thumb,market_price,shop_price,avatar')
            ->where('groupbuy_id',$groupid)
//            ->where('member_id',$usrid)
            ->select();
        $array=array();
//        判定是否有数据
        if(count($data)>0){
            $data[0]->few_people=$data[0]->max_num-count($data);
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;
        return $array;
    }

    /**
     * 用户团购订单提交
     * 陈健英2018-3-28 16:35
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function order($sn,$gro_id=0,$member_id, $skuId,$nuw,$delivery_amount,$real_amount,$paid_amount,$address_name,$address_mobile,$addre_detail,$fc_type,$fencheng)
    {
        $orr=array();
        $orr['sn'] = $sn;  //订单号
        $orr['groupbuy_id'] =$gro_id;                            //自增长ID
        $orr['buyer_id'] = $member_id;
        $orr['pay_type'] = 1;                         //支付类型
        $orr['delivery_amount'] =   $delivery_amount;        //物流总额
        $orr['real_amount'] =$real_amount;          //应付金额
        $orr['paid_amount'] =$paid_amount;         //实付金额
        $orr['address_name'] =$address_name;        //收货人姓名
        $orr['address_mobile'] =$address_mobile;      //手机号
        $orr['addre_detail'] = $addre_detail;       //详细地址
        $orr['fc_type'] = $fc_type;        //特殊商品
        $orr['fencheng'] = $fencheng;            //商品分成
        $orr['order_time'] = time();   //下单时间
        $orr['hongbao']=$real_amount*0.1;       //随机红包
        $or = Db::name('order')->insert($orr);
        $order_id=Db::name('order')->getLastInsID();    //订单Id
        $sku= Db::name('spu-sku')->where('sku_id in ('.$skuId.')')->select();
        $orr_sku=array();
        foreach ($sku as $item){
            $orr_sku['order_id']=$order_id;
            $orr_sku['sku_amount']=$item['shop_price'];
            $orr_sku['spec']=$item['sku_name'];
            $orr_sku['sku_name']=$item['name'];
            $orr_sku['img']=$item['thumb'];
            $orr_sku['number']=$nuw;
            $orr_sku['goodid']=$item['sku_id'];
            $order_sku=Db::name('order_sku')->insert($orr_sku);
        }
        //        判定是否有数据
        if ($or&&$order_sku) {
            $array["data"] =$sn;
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {
            $array["data"] = '';
            $array["type"] = 0;
            $array["lang"] = 'Add_success';
        }

        return $array;
    }

//    团购生成

    public function group_into($sku_id,$pro_id,$member_id,$is_leader,$sn){
        $arr=array();
        $arr['sku_id']=$sku_id;
        $arr['promotion_id']=$pro_id;
        $arr['end_time']=date('Y-m-d H:i:s',time());
        Db::name('group_buy')->insert($arr);
        $id=Db::name('group_buy')->getLastInsID();
        $arr_group=array();
        $arr_group['groupbuy_id']=$id;
        $arr_group['member_id']=$member_id;
        $arr_group['is_leader']=$is_leader;
        $arr_group['sku_id']=$sku_id;
        $arr_group['join_time']=date('Y-m-d H:i:s',time());
        $arr_group['promotion_groupbuy_id']=$pro_id;
        $arr_group['sn']=$sn;
        Db::name('member_groupbuy')->insert($arr_group);
        return $id;
    }

    public function groupCou($title)
    {
        $res = Db::name("promotion_groupbuy")->where("id",$title)->field("id,title,max_num,rules")->select();

        if($res){
            $res = $res[0];
            $res['rules'] = json_decode($res['rules']);
        }

        $arr = array();

        if($res){
            $arr['type'] =1;
            $arr['lang'] = "success";
            $arr['data'] = $res;
        }else{
            $arr['type'] =0;
            $arr['lang'] = "error";
            $arr['data'] = "";
        }

        return $arr;
    }

}