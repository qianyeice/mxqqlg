<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/17
* Time: 10:23
*/
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Shopping_Cart;
use app\api\model\Comment_details;

class Api extends apiController{
    function Cart(){
        $shop_id = input("shop_id");
        $data = new Shopping_Cart();
        return $data->Shoppingcart($shop_id);
    }
    function index_xianshiqianggou(){
        return array(
            $array['type'] = 1,
            $array['data']['huodongid'] = 1,
            $array['data']['img'] ="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=807508755,1387469925&fm=15&gp=0.jpg",
            $array['data']['name'] = "自然",
            $array['data']['shangpinname'] = "龟背牡丹",
            $array['data']['shengyushijian'] =date('Y-m-d H:i:s',time())
        );
    }
    function xinrenshangcheng(){
        return array(
            $array['type'] = 1,
            $array['data']['type'] = "完成购买"
        );
    }
    public function append()
    {
        //获取input值
//        $data['member_id']= input('member_id');
//        $data['spu_id']= input('spu_id');
//        $data['sku_id']= input('sku_id');
//        $data['number']=input('number');
//        $data['img'] = input('img');
//        $data['shangpm'] = input('shangpm');
//        $data['jiage'] = input('jiage');
//        $data['shuliang'] = input('shuliang');
//        $data['skuname']=input('sskuname');
//        //实例化模型
//        $model = new Shop();
//        //接收数据
//        $rlts = $model->Shop_append($data);
//        //返回值
//        return $this->apiReturn($rlts['type'],$rlts['lang'],$rlts['data']);
        return array(
            $array['type'] = 1,
            $array['data']['type'] = "成功"
        );
    }
    function xinrenshangchengshujuliebiao(){
       return array(
           $data['shopname'] = '扫把',
           $data['shopimg'] = '扫把',
           $data['shopjiage'] = '100元',
           $data['shopid'] = 60
       );
    }
    public function mobile_login()
    {
//        $phone = input('phone');
//        $message = input('message');
////        $a = new Session();
////        $fason = $a->get($phone);
//        $fason=cache(md5($phone));
//        $a = new Member();
//        $b = $a->MobileLogin($phone, md5($message), $fason);
//        if ($b["lang"] == lang('success')) {
////            $_COOKIE['duanxin'];
//            $a = new Session();
//            $a->set($phone, null);
//        }
////        else if($b["lang"]==lang('duanxin2')){
////            $a=new Session();
////            $a->clear($phone);
////        }else if($b["lang"]==lang('duanxin3')){
////            $a=new Session();
////            $a->clear($phone);
////        }
//        $this->apiJournal($b["type"], $b["lang"], $b["data"]);
//        return $this->apiReturn($b["type"], $b["lang"], $b["data"]);
        return array(
            $array['type'] = 1,
            $array['data']['yanzhengma']= 546546
        );
    }
    function Method(){
//        $spu_id=input('spu_id');
//        $data=new Comment_details();
//        return $data->Method($spu_id);
        return array(
            $array['type'] = 1,
            $array['data']['pinglun_menber'] = "16541",
            $array['data']['pinglun_neirong'] = "kajdhflkajsdklfjaklsdjfkl",
            $array['data']['pinglun_time'] = date('Y-m-d H:i:s',time())
        );
    }

    function xianshiqianggou_table(){
        return array(
            $array['type'] = 1,
            $array['data']['shangpinid'] = 22,
            $array['data']['shangpinming'] = "asjkdflk",
            $array['data']['shangpinIMG'] = "https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=807508755,1387469925&fm=15&gp=0.jpg",
            $array['data']['jiage'] = 22,
            $array['data']['shnagpinleixing'] = "家具",
            $array['data']['shangpinchandi'] = "江南皮革厂"
        );
    }

    function gengduoshangpinliebiao(){
        return array(
            $array['type'] = 1,
            $array['data']['topimg'] = "https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=807508755,1387469925&fm=15&gp=0.jpg",
            $array['data']['shangpinid'] = 66,
            $array['data']['shangpinming'] = "打神鞭",
            $array['data']['IMG'] = "https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=807508755,1387469925&fm=15&gp=0.jpg",
            $array['data']['jiage'] =543,
        );
    }
    /*
    * 订单支付
    */
    function dingdanzhifu(){
        return array(
            $array['type'] = 1,
            $array['data']['type'] = "成功"
        );
    }
/*
 * 随机红包
 * */
    function suijihongbao(){
        return array(
            $array['type'] = 1,
            $array['data']['qian'] = 111
        );
    }
    /*
     * 删除收货地址
     * */
    function shanchushouhuodizhi(){
        return array(
            $array['type'] = 1,
            $array['data']['type'] = "成功"
        );
    }

    /*
     * 默认地址修改
     * */
    function morendizhixiugai(){
        return array(
            $array['type'] = 1,
            $array['data']['type'] = "成功"
        );
    }
    /*
     * 团购开团
     * */
    function tuangoukaituan(){
        return array(
            $array['type'] = 1,
            $array['data']['type'] = "成功"
        );
    }
}
