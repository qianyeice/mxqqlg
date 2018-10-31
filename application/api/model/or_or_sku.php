<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/24
 * Time: 10:33
 */

namespace app\api\model;
use think\Db;
use think\Model;
//class or_or_sku extends Model
//{
//
//    /*
//* 陈健英
//* 我的团购订单
//* */
//    public function mdd($id, $sp)
//    {
//        $time=date('Y-m-d H:i:s',strtotime('-1 day'));
//        if ($sp == 1) {                  //进行中
//            $f = $this->where('o_groupbuy_id > 0 and buyer_id="' . $id . '" and end_time>"'.$time.'"')->select();
//        } elseif ($sp == 2) {              //结束
//            $f = $this->where('o_groupbuy_id > 0 and buyer_id="' . $id . '" and end_time<"'.$time.'"')->select();
//        }
//        if (count($f)>0) {
//            foreach ($f as $k=>$v){
//                $zh[$k]['num']=Db::name('member_groupbuy')->where('groupbuy_id',$v['id'])->count();
//                $zh[$k]['max_num']=$this->query('select p.max_num from member_groupbuy as m JOIN promotion_groupbuy as p ON m.promotion_groupbuy_id=p.id where groupbuy_id="'.$v['id'].'" limit 1');
//                $zh[$k]['sku_amount']=$v['sku_amount'];
//                $zh[$k]['buyer_id']=$v['buyer_id'];
//                $zh[$k]['o_groupbuy_id']=$v['o_groupbuy_id'];
//                $zh[$k]['spec']=$v['spec'];
//                $zh[$k]['sku_name']=$v['sku_name'];
//                $zh[$k]['img']=$v['img'];
//                $zh[$k]['sn']=$v['sn'];
//            }
//            $array["data"]=$zh;
//            $array["type"] = 1;
//            $array["lang"] = 'success';
//        } else {
//            $array["type"] = 0;
//            $array["lang"] = 'meishuju';
//            $array["data"]=null;
//        }
//        return $array;
//    }
//}

class or_or_sku extends Model
{

    /*
* 陈健英
* 我的团购订单
* */
    public function mdd($id, $sp)
    {
//        $time=date('Y-m-d H:i:s',strtotime('-1 day'));
        $time =date("Y-m-d H:i:s",time());
        $f = array();
        if ($sp == 1) {                  //进行中
            $f = $this->where('o_groupbuy_id > 0 and buyer_id="' . $id . '" and end_time>"'.$time.'"')->select();
        } elseif ($sp == 2) {              //结束
            $f = $this->where('o_groupbuy_id > 0 and buyer_id="' . $id . '" and end_time<"'.$time.'"')->select();
        }
        if (count($f)>0) {
            foreach ($f as $k=>$v){
                $zh[$k]['num']=Db::name('member_groupbuy')->where('groupbuy_id',$v['id'])->count();
                $zh[$k]['max_num']=$this->query('SELECT p.max_num FROM member_groupbuy as g JOIN promotion_groupbuy as p on g.promotion_groupbuy_id=p.id WHERE g.groupbuy_id='.$v['id']);
                $zh[$k]['sku_amount']=$v['sku_amount'];
                $zh[$k]['buyer_id']=$v['buyer_id'];
                $zh[$k]['o_groupbuy_id']=$v['o_groupbuy_id'];
                $zh[$k]['spec']=$v['spec'];
                $zh[$k]['sku_name']=$v['sku_name'];
                $zh[$k]['img']=$v['img'];
                $zh[$k]['sn']=$v['sn'];
                $zh[$k]['goodid'] = $v['goodid'];
            }
            $array["data"]=$zh;
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'error';
            $array["data"]= null;
        }
        return $array;
    }
}