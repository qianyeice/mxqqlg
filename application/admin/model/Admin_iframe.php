<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/4/6
 * Time: 14:42
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class Admin_iframe extends Model{
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取首页order表的数据
     * return array
     * Time: 14:42
     */
    function order(){
        $count=[];
        $count['Pending_deliver']=0;
        $count['Pending_evaluate']=0;
        $count['Pending_payment']=0;
        $count['confirm_status']=0;
        $data = Db::table('order')->field('status,confirm_status')->select();

        for ($i=0;$i<count($data);$i++){
            if ($data[$i]['status']=='1'){
                $count['Pending_deliver']++;
            }elseif ($data[$i]['status']=='3'){
                $count['Pending_evaluate']++;
            }elseif ($data[$i]['status']=='4'){
                $count['Pending_payment']++;
            }
            if ($data[$i]['confirm_status']=='0'){
                $count['confirm_status']++;
            }
        }
        return $count;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取首页退款退货的数据
     * return array
     * Time: 14:42
     */
    function refund(){
        $count=[];
        $count['moneny']=0;
        $count['goods']=0;
        $data = Db::table('refund')->field('choose')->select();
        for ($i=0;$i<count($data);$i++){
           if ($data[$i]['choose']=='0'){
               $count['moneny']++;
           }elseif ($data[$i]['choose']=='1'){
               $count['moneny']++;
               $count['goods']++;
           }
        }
        return $count;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取首页商品的数据
     * return array
     * Time: 14:42
     */
    function goods_spu(){
        $count=[];
        $count['status']=0;
        $count['no_status']=0;
        $count['number']=0;
        $data = Db::table('view_goodss')->group('id')->select();
        for ($i=0;$i<count($data);$i++){
            if ($data[$i]['status']=='1'){
                $count['status']++;
            }elseif ($data[$i]['status']=='0'){
                $count['no_status']++;
            }
            if ($data[$i]['number']<'10'){
                $count['number']++;
            }
        }
        return $count;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取已完成订单总数
     * return array
     * Time: 14:42
     */
    function finish_status(){
        $data = Db::table('order')->field('count(*)')->where('finish_status','2')->select();
        return $data;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取注册会员总数
     * return array
     * Time: 14:42
     */
    function member(){
        $data = Db::table('member')->field('count(*) cc')->where('is_delete','0')->select();
        return $data;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取今日登录会员总数
     * return array
     * Time: 14:42
     */
    function today_login(){
        $today = strtotime(date('Y-m-d', time()));
        $data = Db::table('member')->field('count(*) cc')->where('is_delete','0')->where('login_time','>=',$today)->select();
        return $data;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取今日销售总数
     * return array
     * Time: 14:42
     */
    function sale(){
        $today = strtotime(date('Y-m-d', time()));
        $today=date('Y-m-d H:i:s',$today);
        $end = strtotime(date('Y-m-d',strtotime('+1 day')));
        $end=date('Y-m-d H:i:s',$end);
        $data = Db::table('order')->field('paid_amount,count(*) c,sum(paid_amount) as sumpaid')
            ->where('pay_time BETWEEN "'.$today.'" AND "'.$end.'" ')
            ->where('pay_status','1')
            ->select();
        return $data[0]["sumpaid"];
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取本月销售总数
     * return array
     * Time: 14:42
     */
    function month(){
        $today =strtotime(date('Y-m'));
        $today=date('Y-m-d H:i:s',$today);
        $end=strtotime(date('Y-m',strtotime('+1 month')));
        $end=date('Y-m-d H:i:s',$end);
        $data = Db::table('order')->field('paid_amount,count(*) c,sum(paid_amount) as sumpaid')
            ->where('pay_time BETWEEN "'.$today.'" AND "'.$end.'" ')
            ->where('pay_status','1')
            ->select();
        return $data[0]["sumpaid"];
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取今年销售总数
     * return array
     * Time: 14:42
     */
    function year(){
        $today=strtotime(date('y').'-1-1');
        $today=date('Y-m-d H:i:s',$today);
        $end=strtotime((date('y')+1).'-1-1');
        $end=date('Y-m-d H:i:s',$end);
        $data = Db::table('order')->field('paid_amount,count(*) c,sum(paid_amount) as sumpaid')
            ->where('pay_time BETWEEN "'.$today.'" AND "'.$end.'" ')
            ->where('pay_status','1')
            ->select();
        return $data[0]["sumpaid"];
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取微信关注人数
     * return array
     * Time: 14:42
     */
    function wechat_concerns(){
        $data = Db::table('member')->field('count(*) cc')->where('is_delete','0')->where('subscribe','1')->select();
        return $data;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取微信取消关注人数
     * return array
     * Time: 14:42
     */
    function wechat_unconcerns(){
        $data = Db::table('member')->field('count(*) cc')->where('is_delete','0')->where('subscribe','0')->select();
        return $data;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取昨日确认收货订单金额
     * return array
     * Time: 14:42
     */
    function yesterday_money(){
        $yesday_mny=0;
       $data = Db::table('view_order_delivery')->where('isreceive','1')->whereTime('receive_time', 'yesterday')->select();
       for ($i=0;$i<count($data);$i++){
           $yesday_mny+=$data[$i]['paid_amount'];
       }
       return $yesday_mny;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取分红比例
     * return array
     * Time: 14:42
     */
    function getproportion(){
        $data = Db::table('vip_red')->where('is_open','1')->find();
        return $data['proportion'];
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/4/6
     * 获取昨日分红池
     * return array
     * Time: 14:42
     */
    function getyesred(){
        $data = Db::table('vip_red')->where('is_open','1')->find();
        return $data['yesterday_red'];
    }
}