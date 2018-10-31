<?php
/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * Date: 2018/3/27
 * Time: 15:52
 */
namespace app\api\model;

use think\Db;
use think\Model;

class View_creatorder extends Model{
    /**
     * Created by PhpStorm.
     * User: 谢岸霖
     * Date: 2018/3/28
     * Time: 21:20
     * 生成订单
     * $id为用户id
     * $order为一维数组装的订单信息
     * $ordersku为二维数组订单内物品信息
     */
    public function orderCreat($id,$order,$ordersku){
        $Ordernumber=time().$id;
//                $datas=$this->insert($data[$i]['orderid'],$Ordernumber,$id,$data[i]['pay_tpye'],$data[i]['delivery_amount'],$data[i]['real_amount'],$data[i]['paid_amount'],$data[$i]['pay_method'],$data[$i]['pay_sn'],$data[i]['address_name'],$data[$i]['address_mobile'],$data[$i]['addre_detail'],$data[$i]['invoice_tax'],$data[i]['status'],$data[$i]['pay_status'],$data[$i]['confirm_status'],$data[$i]['finish_status'],$data[$i]['pay_time'],$data[$i]['use_coin'],$data[$i]['promot_amount'],$data[$i]['groupbuy_id'],$data[$i]['sn_used'],$data[$i]['fc_type'],$data[$i]['display'],$data[$i]['fencheng'],$data[$i]['hd_type'],$data[$i]['hongbao'],$data[$i]['orderid'],$data[$i]['sku_amount'],$data[$i]['spec'],$data[$i]['sku_name'],$data[$i]['url'],$data[$i]['img'],$data[$i]['did'],$data[$i]['goodid']);
        if (count($order)>0&&count($ordersku)>0){
//            var_dump(Db::table('order')->insert(array('buyer_id'=>$order)));
                    $orders=Db::table('order')->insert(array('id'=>null,'sn'=>$Ordernumber, 'buyer_id'=>$order['buyer_id'], 'pay_type'=>$order['pay_type'],
                        'delivery_amount'=>$order['delivery_amount'],'real_amount'=>$order['real_amount'],'paid_amount'=>$order['paid_amount'],
                        'pay_method'=>$order['pay_method'],'pay_sn'=>$order['pay_sn'],'address_name'=>$order['address_name'],'address_mobile'=>$order['address_mobile'],
                        'addre_detail'=>$order['addre_detail'],'invoice_tax'=>$order['invoice_tax'],'status'=>$order['status'],'pay_status'=>$order['pay_status'],'confirm_status'=>$order['confirm_status'],
                        'finish_status'=>$order['finish_status'],'pay_time'=>$order['pay_time'],'use_coin'=>$order['use_coin'],'promot_amount'=>$order['promot_amount'],'groupbuy_id'=>$order['groupbuy_id'],
                        'sn_used'=>$order['sn_used'],'fc_type'=>$order['fc_type'],'display'=>$order['display'],'fencheng'=>$order['fencheng'],'hd_type'=>$order['hd_type'],'hongbao'=>$order['hongbao']));
            for ($i=0;$i<count($ordersku);$i++){
                    $orderskus=Db::table('order_sku')->insert(array('id'=>null,'order_id'=>$ordersku[$i]['orderid'],'sku_amount'=>$ordersku[$i]['sku_amount'],
                        'spec'=>$ordersku[$i]['spec'],'sku_name'=>$ordersku[$i]['skuname'],'url'=>$ordersku[$i]['url'],'img'=>$ordersku[$i]['img'],'did'=>$ordersku[$i]['did'],
                        'goodid'=>$ordersku[$i]['goodid']));
            }
            if ($orders>0 && $orderskus>0){
                $datas=[
                    'type'=>'1',
                    'data'=>'添加成功'
                ];
            }else{
                $datas=[
                    'type'=>'0',
                    'data'=>'订单创建失败'
                ];
            }
        }else{
            $datas=[
                'type'=>'0',
                'data'=>'订单创建失败'
            ];
        }
        return $datas;
    }
}
