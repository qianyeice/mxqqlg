<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/8
 * Time: 11:48
 */

namespace app\admin\model;

use api\WxLogin;
use app\api\controller\Wxapi;
use https\curl;
use think\Model;
use think\Db;

class ViewInvoice extends Model
{
    /**
     * 发货单管理
     * 程建 2018-4-8 12：:23
     * @param $type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function invoice_distribution($search, $type, $page, $count)
    {
        $array = array();
        if (!empty($search)) {
            $select['sn | username | address_mobile | address_name'] = array('like', "%$search%");
        }
        $string = 'id,odid,sn,username,address_name,address_mobile,addre_detail,finish_status,status,hd_type,distribution_type';
        $select['is_display'] = ['in', ('1')];
        if ($type > 0) {
            $select['distribution_type'] = ['=', "$type"];
        }
        $data = listPage($string, $select, $page, $count, $this, false);

        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');;
        }
        $array["data"] = $data;

        return $array;
    }

    /**订单管理
     * 程建 2018-4-8 13:55
     * @param $type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function order_management($type, $page, $count, $export = false)
    {
        $string = 'id,sn,username,address_name,address_mobile,order_time,paid_amount,pay_type,pay_sn,groupbuy_id,pay_method,status,pay_status,confirm_status,finish_status,pay_time,hd_type';

        if ($type == 1) {
//            待付款
            $select['status'] = ['=', '4'];
        } elseif ($type == 2) {
//            待确认
            $select['pay_status'] = ['=', '1'];
        } elseif ($type == 3) {
//            待发货
            $select['status'] = ['=', '1'];
        } elseif ($type == 4) {
//            已发货
            $select['status'] = ['=', '2'];
        } elseif ($type == 5) {
//            已完成
            $select['finish_status'] = ['=', '2'];
        } elseif ($type == 6) {
//            已取消
            $select['hd_type'] = ['=', '1'];
        } elseif ($type == 7) {
//            已回收

            $select['hd_type'] = ['=', '2'];
        } elseif ($type == 8) {
//            昨天确认收货订单,昨天时间戳
            $beginYesterday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
            $endYesterday = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
            $select['receive_time'] = ['>', date("Y-m-d H:i:s", $beginYesterday)];
            $select['receive_time'] = ['<', date("Y-m-d H:i:s", $endYesterday)];
        } else {
//            全部订单
            $select = '';
        }

        $data = listPage($string, $select, $page, $count, $this, false);


        $array = array();
        if ($export) {
            $array["data"] = $data;
            return $array;
        } else {
            if (count($data) > 0) {
                $array["type"] = 1;
                $array["lang"] = lang('success');
            } else {
                $array["type"] = 0;
                $array["lang"] = lang('noData');;
            }
            $array["data"] = $data;
            return $array;
        }
    }

    /**
     * 订单详情
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function order_details($id, $user)
    {
        if ($user['is_supplier'] == '0') {
            $data = $this->where('id', $id)->select();
        } else {
            $data = $this->where('id', $id)->where('bang_id', $user['bang_id'])->select();
        }
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');;
        }
        $array["data"] = $data;
        return $array;
    }

    public function or_log($id){
        $or=Db::name('order')->field('sn')->where('id',$id)->find();
        $or_log=Db::name('order_log')->where('order_sn',$or['sn'])->order('system_time desc')->select();
        return $or_log;
    }
    /**
     * 配送状态修改
     * @param $id订单ID
     * @param $type配送状态
     * @param $text操作备注
     * @return array
     */
    function distribution_handle($id, $type, $text)
    {
//        $array = array();
//
//        if ($type == 1) {
//            $array['finish_status'] = '2';
//        } elseif ($type == 2) {
//            $array['status'] = '2';
//        } else {
//            $array['hd_type'] = '1';
//        }
//        return modify($id, $array, $this);

        $data = ['operating_notes' => $text, 'distribution_type' => $type];
        $beef = Db::table('order_delivery')->where('order_id', $id)->update($data);

        return $beef;
    }

    /**
     * 删除发货单
     * @param $id删除ID
     * @return mixed
     */
    function Lnvoiceman_del($id)
    {
//        调用删除函数
        return $data = del($id, 'odid', $this);
    }

    /**
     * 确认付款页面
     * @param $id订单id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function confirm_payment_page($id)
    {
        $data = $this->field('id,real_amount,pay_method,sn')->where('id', $id)->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }

    /**
     * 确认付款(修改)
     * @param $id订单id
     * @param $time付款时间
     * @param $money金额
     * @param $mode方式
     * @param $third第三方支付号
     * @return mixed
     */
    function confirm_payment($id, $time, $money, $mode, $third, $remarks, $order_sn)
    {
        $array = ['paid_amount' => $money, 'pay_sn' => $third, 'pay_method' => $mode, 'pay_time' => $time, 'pay_status' => '1'];
        $order = Db::name('order')->where('id', $id)->update($array);
        $user_id = $_SESSION['module']['id'];
        $log = $this->order_log($order_sn, $user_id, $remarks, $type = '后台支付');
        return $log;
    }


    function order_log($order_sn, $operator_id, $remarks, $type)
    {
        $user = Db::name('admin_user')->where('id', $operator_id)->find();
        $order_log = Db::name('order_log');
        $log_add = ['order_sn' => $order_sn, 'action' => $type, 'operator_id' => $user['id'],
            'operator_name' => $user['username'], 'operator_type' => $user['is_supplier'],
            'msg' => $remarks, 'system_time' => time(), 'clientip' => $_SERVER['REMOTE_ADDR']];
        return insert($log_add, $order_log);
    }

    /**
     * 修改应付金额
     * @param $id订单id
     * @param $data数组
     * @return array
     */
    function up_money($id, $data)
    {
        return modify($id, $data, $this);
    }

    /**
     * 没付款取消订单
     * @param $id订单id
     * @return array
     */
    function cancel_onpay($id)
    {
        $data = ['hd_type' => 1, 'status' => '0'];
        return modify($id, $data, $this);
    }

    /**
     * 确认订单
     * @param $id
     * @return array
     */
    function confirm_order($id, $msg, $sn)
    {
        $data = ['confirm_status' => '2'];
        $s=modify($id, $data, $this);
        return  $s;
    }
    /**
     * 已付款，取消订单页面
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function cancel_payment($id)
    {
        $data = $this->field('id,buyer_id,paid_amount,sku_amount,spec,sku_name,img')->where('id', $id)->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }

    /**
     * 取消已付款订单，添加退款
     * @param $val
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function confirm_cancel($val)
    {
        $orderId = $val['id'];
        $mid = $val['mid'];
        $sku_name = $val['sku_name'];
        $spec = $val['spec'];
        $img = $val['img'];
        $data = $this->query('call pro_cancel_add_refund(' . $orderId . ',' . $mid . ',"' . $sku_name . '","' . $img . '","' . $spec . '")');
        $array = array();
        if ($data[0][0]['type'] == 1) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        return $array;
    }

    /**
     * 订单作废
     * @param $id
     * @return array
     */
    function order_to_void($id)
    {
        $data = ['hd_type' => 2];
        return modify($id, $data, $this);
    }

    /**
     * 订单确认
     * @param $id
     * @return array
     */
    function order_complete($id)
    {
        $data = ['hd_type' => 2];
        return modify($id, $data, $this);
    }

    /**
     * 确认发货页面，商品信息
     * @param $id订单id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function qr_order($id)
    {
        $user_id = $_SESSION['module']['id'];
        $user = Db::name('admin_user')->where('id', $user_id)->find();
        if ($user['is_supplier'] == 1) {
            $data = Db::name('order')->alias('o')->join('order_sku k', 'o.id = k.order_id')
                ->field('k.id,k.sku_amount,k.spec,k.sku_name,k.img,k.number,o.status,o.sn,k.order_id,s.fahuo,')
                ->where('fahuo', '0')->where('band_id', $user['band_id'])->where('o.id', $id)
                ->select();
        } else {
            $data = Db::name('order')->alias('o')->join('order_sku k', 'o.id = k.order_id')
                ->field('k.id,k.sku_amount,k.spec,k.sku_name,k.img,k.number,o.status,o.sn,k.order_id,k.fahuo')
                ->where('fahuo', '0')->where('o.id', $id)
                ->select();
        }
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }




    function deliver_goods_confirm($id)
    {
        $user_id = $_SESSION['module']['id'];
        $user = Db::name('admin_user')->where('id', $user_id)->find();
        if ($user['is_supplier'] == 1) {
            $data = $this->field('id,sku_amount,spec,sku_name,img,number,status,sn')->where('fahuo', '0')->where('band_id', $id)->where('id', $id)->select();
        } else {
            $data = $this->field('id,sku_amount,spec,sku_name,img,number,status,sn')->where('fahuo', '0')->where('id', $id)->select();
        }

        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }

    /**
     * 订单发货，物流选择
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function confirm_order_logistics($id, $wul, $d_sn, $o_sn, $text, $o_id)
    {
        if (!empty($wul)) {
            $wulmob = Db::name('delivery')->where('id', $wul)->find();
        }
        //发货添加
        foreach ($id as $i) {
            $add['order_sn'] = $o_sn;
            $add['delivery_id'] = $wul;
            $add['delivery_name'] = isset($wulmob['name']) ? $wulmob['name'] : "";
            $add['delivery_sn'] = $d_sn;
            $add['delivery_time'] = date('Y-m-d H:i:s',time());
            $add['operating_notes'] = $text;
            $add['order_sku_id'] = $i;
            Db::name('order_delivery')->insert($add);
            $ww = Db::name('order_sku')->where('id', $i)->update(array('fahuo' => '1'));
        }
        Db::name('order')->where('id', $o_id)->update(array('dist' => '1'));
        $fah = Db::name('order_sku')->where('fahuo', '0')->where('order_id', $o_id)->count();
        if ($fah == 0) {
            Db::name('order')->where('id', $o_id)->update(array('dist' => '2'));
        }

        $array = array();
        if ($ww) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        return $array;
    }

    /**
     * 修改订单物流信息
     * @param $orderId订单id
     * @param $logid物流id
     * @param $sn物流单号
     * @param $text物流名字
     * @return array
     */
    function replace_order_logistics($orderId, $logid, $sn, $text)
    {
        $data = ['delivery_id' => $logid, 'delivery_name' => $text, 'delivery_sn' => $sn];
        return modify($orderId, $data, $this);
    }

    /**
     * 确认完成，订单
     * 冯云祥
     * @param $id 订单id
     * @return array
     */
    function confirm_order_complete($id, $mgs)
    {
//              有问题
        $d = new WxLogin();
        $f = $d->get_access_token();
        $access_token = $f['data'];
        $data = Db::name("order")->field("groupbuy_id,paid_amount,buyer_id,sn")->where("id", $id)->select();
        $shifu = $data[0]['paid_amount'];//订单实付总额
        $member_id = $data[0]['buyer_id'];//用户id
        $sn = $data[0]['sn'];//订单号

        $openid = Db::name("member")->field("openid")->where("id", $member_id)->select();
        $openid = $openid[0]['openid'];//用户openid

//        $coin = $this->coin($member_id, $data[0]['groupbuy_id'], $shifu, $id);//加梦想币
        $integralset = $this->integralset($shifu, $member_id, $data[0]['groupbuy_id'], $sn, $access_token, $id);//加积分

        $parent1 = Db::name("member")->field("parent_id")->where("id", $member_id)->select();
        $parent1 = $parent1[0]['parent_id'];//上级
        $openid1 = Db::name("member")->field("openid")->where("id", $parent1)->select();//上级openid
        $parent1_distribution = Db::name("member")->field("distribution")->where("id", $parent1)->select();//上级原有佣金
        $parent1_direct_sale = Db::name("distribution")->field("direct_sale")->where(["is_delete" => '1', 'name' => '员工'])->select();//员工分销比例
        $fencheng = Db::name("order")->field("fencheng")->where("id", $id)->select();//该商品的分成
        $distribution = $fencheng[0]['fencheng'] * ($parent1_direct_sale[0]['direct_sale'] / 100);//上级获得的钱
        if ($parent1) {
            $asda = Db::name("member")->where("id", $parent1)->update(["distribution" => $parent1_distribution[0]['distribution'] + $distribution]);//上级加佣金
            $zhi = [
                'type' => '1',
            ];
            $cg = Db::name("get_distribution")->where('p_id', $parent1)->updata($zhi);//添加佣金日志
        }
        $parent2 = Db::name("member")->field("parent_id")->where("id", $parent1)->select();
        if ($parent2) {
            $parent2 = $parent2[0]['parent_id'];//上上级id
            $openid2 = Db::name("member")->field("openid")->where("id", $parent2)->select();//上上级openid
            $parent1_indirect_sale = Db::name("distribution")->field("indirect_sale")->where(["is_delete" => '1', 'name' => '合伙人'])->select();//合伙人分销比例
            $distribution2 = $fencheng[0]['fencheng'] * ($parent1_indirect_sale[0]['indirect_sale'] / 100);//上上级获得的钱
            $parent1_distribution2 = Db::name("member")->field("distribution")->where("id", $parent2)->select();//上级原有佣金
            $parent1_distribution2 = $parent1_distribution2[0]['distribution'] + $distribution2;
            $qw = Db::name("member")->where("id", $parent2)->update(["distribution" => $parent1_distribution2]);//上上级加佣金
            $zhi = [
                'type' => '1',
            ];
            $cg1 = Db::name("get_distribution")->where('p_id', $parent1)->updata($zhi);//添加佣金日志
            $gf = $this->memcg_distribution($distribution . '我是上级', $openid1[0]['openid'], $access_token);//发送佣金模板消息上级   需要上级openid
            $qwr = $this->memcg_distribution($distribution2 . '我是上上级', $openid2[0]['openid'], $access_token);//发送佣金模板消息上上级     需要上上级openid
        }

        if ($data[0]['groupbuy_id'] == 0 || $data[0]['groupbuy_id'] == null) {
            $parents = $this->parents($member_id, $fencheng);
        } else {
            $Group_ratio = $this->Group_ratio($data[0]['groupbuy_id']);
            $fencheng[0]['fencheng'] = $fencheng[0]['fencheng'] * $Group_ratio;
            $this->parents($member_id, $fencheng);
        }
//        $or = Db::name('order')->where('id', $id)->update(array('finish_status' => '2'));
//        $user_id = $_SESSION['module']['id'];
//        $log = $this->order_log($data[0]['sn'], $user_id, $mgs, $type = '订单完成');
//        return $or;

    }


    /*
     * 判断当前团购打几折
     * $groupbuy_id 团购id
     * 冯云祥
     */
    function Group_ratio($groupbuy_id)
    {
        $member_groupbuy = Db::name("member_groupbuy")->field('promotion_groupbuy_id')->where('groupbuy_id', $groupbuy_id)->select();
        $promotion_groupbuy_id = $member_groupbuy[0]['promotion_groupbuy_id'];//团购规则id
        $promotion_groupbuy = Db::name("promotion_groupbuy")->where('id', $promotion_groupbuy_id)->select();
        $pipo = count($member_groupbuy);//人数
        $groupbuy_array = json_decode($promotion_groupbuy[0]['rules'], true);
        foreach ($groupbuy_array as $key => $v) {
            if ($key == $pipo) {
                $Discount = (100 - $v) / 100;//当前团购打折
            }
        }
        return $Discount;
    }


    /*
     * 坐席比例
     * 冯云祥
     * $id  传  1员工  2合伙人  3发起人  4创始人
     * return 获得的钱
     */
    function Proportion($fencheng, $id)
    {
        $Proportion_array = Db::name("user_grade")->where('id', $id)->select();
        $get_money = $fencheng[0]['fencheng'] * $Proportion_array[0]['bili'] / 100;
        return $get_money;
    }

    /*
     * 坐席加钱
     * $member_id用户子级id
     * $p_member_id用户父级id
     * $money钱
     * 冯云祥
     */
    function addmoney($member_id, $money)
    {
        $y_money = Db::name("member")->field('money,openid')->where('id', $member_id)->select();
        $yes = Db::name('member')->where('id', $member_id)->update(['money' => $y_money[0]['money'] + $money]);
        if ($yes) {
            $a = $this->distribution($money, $member_id);
            if ($a) {
                $d = new WxLogin();
                $f = $d->get_access_token();
                $access_token = $f['data'];
                $this->memcg_distribution($money, $y_money[0]['openid'], $access_token);//发送佣金模板消息
            }
        }
    }

    /*
     * 添加佣金日志
     * 冯云祥
     * $money 获得的钱
     * $member_id 子级id
     * $p_member_id父级id
     */
    function distribution($money, $member_id)
    {
        $id = Db::name("member")->field('id')->where('parent_id', $member_id)->select();
        $zhi = [
            'type' => '1',
            'time' => time(),
            'money' => $money,
            'p_id' => $id[0]['id'],
            'member_id' => $member_id,
        ];
        $cg1 = Db::name("get_distribution")->insert($zhi);
        return $cg1;
    }


    /*
     * 获得坐席分成人员
     * 冯云祥
     * $member_id当前用户id
     * $y判断员工
     * $h判断合伙人
     * $f判断发起人
     * $c判断创始人
     */
    function parents($member_id, $fencheng, $y = 0, $h = 0, $f = 0, $c = 0)
    {
        $parent = Db::name("member")->field("id,is_special,parent_id")->where("id", $member_id)->select();
        if ($parent) {
            if ($parent[0]['is_special'] == 1 && $y <= 0) {
                $y++;
                $money = $this->Proportion($fencheng, 1);
                $this->addmoney($parent[0]['id'], $money);
            }
            if ($parent[0]['is_special'] == 2 && $h <= 0) {
                $h++;
                $money = $this->Proportion($fencheng, 2);
                $this->addmoney($parent[0]['id'], $money);
            }
            if ($parent[0]['is_special'] == 3 && $f <= 0) {
                $f++;
                $money = $this->Proportion($fencheng, 3);
                $this->addmoney($parent[0]['id'], $money);
            }
            if ($parent[0]['is_special'] == 4 && $c <= 0) {
                $c++;
                $money = $this->Proportion($fencheng, 4);
                $this->addmoney($parent[0]['id'], $money);
            }
            $this->parents($parent[0]['parent_id'], $fencheng, $y, $h, $f, $c);
        }

    }


    /*
     * 团购、个人加积分、梦想币
     * 冯云祥
     * $shifu  订单实付总额   $member_id   用户id
     */
    public function integralset($shifu, $member_id, $groupbuy_id, $sn, $access_token, $id)
    {
        $data = Db::name("site_integralset")->field("integralgain,integraldate,integralmultiples")->select();
        $integralgain = $data[0]['integralgain'];//积分获取比例
        $integraldate = $data[0]['integraldate'];//积分翻倍获取日期
        $integralmultiples = $data[0]['integralmultiples'];//积分获取倍数
        $shijian = date("Y-m-d", time());//当前时间
        $integral = Db::name("member")->field("coin,integral")->where("id", $member_id)->select();//用户原有梦想币、积分
        if ($groupbuy_id == 0 || $groupbuy_id == null) {
            if ($shijian == $integraldate) {//x倍数积分
                $get = $shifu * $integralmultiples * ($integralgain / 100);//获得积分
                $integral = $integral[0]['integral'] + $get;
            } else {
//            不x倍数积分
                $get = $shifu * ($integralgain / 100);//获得积分
                $integral = $integral[0]['integral'] + $get;
            }
            $bili = Db::name("site_dream")->field("buyordinary")->select();
            $bili = $bili[0]['buyordinary'];//梦想币获得比例
            $get = $shifu * ($bili / 100);//不是团购时获得的梦想币个数
            $coin = $integral[0]['coin'] + $get;
            Db::name("member")->where("id", $member_id)->update(["integral" => $integral, 'coin' => $coin]);//添加积分
            $touxiang = Db::name("member")->field("openid,avatar")->where("id", $member_id)->select();//用户头像查询
            $zhi = [
                'time' => time(),
                'get' => '购买',
                'number' => $get,
                'member_id' => $member_id,
                'img' => $touxiang[0]['avatar'],
            ];
            $que = Db::name("get_integral")->insert($zhi);//添加积分日志
            $this->memcg($sn, $integral, $coin, $touxiang[0]['openid'], $access_token);//发消息
            return $get;
        } else {
            $renshu = Db::name("member_groupbuy")->where('groupbuy_id', $groupbuy_id)->select();//团购长度
            foreach ($renshu as $key => $val) {
                $integral = Db::name("member")->field("integral,coin")->where("id", $val['member_id'])->select();//用户原有积分、梦想币
                $touxiang = Db::name("member")->field("avatar")->where("id", $val['member_id'])->select();//用户头像查询
                $site_dream = Db::name("site_dream")->field("buybulk")->select();//团购梦想币比例查询
                $sku_id = Db::name("order_sku")->field("goodid")->where("order_id", $id)->select();
                if ($val['is_leader'] == 1) {
                    Db::name("member")->where("id", $val['member_id'])->update(["integral" => $integral[0]['integral'] + $shifu * count($renshu), "coin" => $integral[0]['coin'] + ($shifu * count($renshu)) * ($site_dream[0]['buybulk'] / 100)]);//团长添加积分
                    $get = $shifu * count($renshu);
                    $zhi = [
                        'time' => time(),
                        'get' => '团长购买',
                        'number' => $get,
                        'member_id' => $val['member_id'],
                        'img' => $touxiang[0]['avatar'],
                    ];
                    $dream = [
                        'time' => date('Y-M-D H:i:s', time()),
                        'get' => '团长购买',
                        'number' => ($shifu * count($renshu)) * ($site_dream[0]['buybulk'] / 100),
                        'member_id' => $val['member_id'],
                        'sku_id' => $sku_id[0]['goodid'],
                    ];
                } else {
                    Db::name("member")->where("id", $val['member_id'])->update(["integral" => $integral[0]['integral'] + $shifu, "coin" => $integral[0]['coin'] + $shifu * ($site_dream[0]['buybulk'] / 100)]);//团员添加积分
                    $get = $shifu;
                    $zhi = [
                        'time' => time(),
                        'get' => '团员购买',
                        'number' => $get,
                        'member_id' => $val['member_id'],
                        'img' => $touxiang[0]['avatar'],
                    ];
                    $dream = [
                        'time' => date('Y-M-D H:i:s', time()),
                        'get' => '团员购买',
                        'number' => $shifu * ($site_dream[0]['buybulk'] / 100),
                        'member_id' => $val['member_id'],
                        'sku_id' => $sku_id[0]['goodid'],
                    ];
                }
                Db::name("get_integral")->insert($zhi);//添加积分日志
                Db::name("get_dream")->insert($dream);//添加梦想币日志
                $openid = Db::name("member")->field("openid")->where("id", $val['member_id'])->select();//用户$openid
                if ($val['is_leader'] == 1) {
                    $this->memcg($sn, $get, ($shifu * count($renshu)) * ($site_dream[0]['buybulk'] / 100), $openid[0]['openid'], $access_token);//发消息
                } else {
                    $this->memcg($sn, $get, $shifu * ($site_dream[0]['buybulk'] / 100), $openid[0]['openid'], $access_token);//发消息
                }
            }
        }

    }



    //发送积分、梦想币模板消息
    //    冯云祥
    function memcg($sn, $integralset, $coin, $openid, $access_token)
    {
        $a = new curl();
//        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=11_BiMqLxI3UHfQhZBxB2wKyal8L6VPBdchRWn8NiRl0BQ9Issbfl2kisFe9n9Y5gzaNYwReZ7MeUYNevtSdmE9u-O4wIvdqeToSqA1HK48lrYw_Nf95rPAHVZxrzy_wy6tHs10hY-4znZ-GhWFVCLjACAFMV";
        //        touser    用户openid
        $data = '     {
           "touser":"' . $openid . '",
           "template_id":"0wjEBnEw6frkrenf2bkJ5Lln_kct3EE-4lM5QI8mZj8",
           "data":{
                    "first": {
                       "value":"尊敬的客户您好，您的积分和梦想币已经发送到您的账户，请查收",
                       "color":"#173177"
                   },
                   "order": {
                       "value":"' . $sn . '",
                       "color":"#173177"
                   },
                   "money":{
                       "value":"积分' . $integralset . '个,梦想币' . $coin . '元",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"欢迎再次购买！",
                       "color":"#173177"
                   }
           }
       }';
        $c = $a->curl_post_https($url, $data);
        return $c;
    }


    //发送佣金模板消息
    //    冯云祥
    function memcg_distribution($qian, $openid, $access_token)
    {
        $time = date("Y-m-d H:i:s", time());
        $a = new curl();
//        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=11_BiMqLxI3UHfQhZBxB2wKyal8L6VPBdchRWn8NiRl0BQ9Issbfl2kisFe9n9Y5gzaNYwReZ7MeUYNevtSdmE9u-O4wIvdqeToSqA1HK48lrYw_Nf95rPAHVZxrzy_wy6tHs10hY-4znZ-GhWFVCLjACAFMV";
        //        touser    用户openid
        $data = '     {
           "touser":"' . $openid . '",
           "template_id":"S-qaGwIT8pXgcg-LGYfzkB6kmsRK50cS1_41mYkoQGM",
           "data":{
                    "first": {
                       "value":"您获得了一笔新的佣金。",
                       "color":"#173177"
                   },
                   "keyword1": {
                       "value":"' . $qian . '",
                       "color":"#173177"
                   },
                   "keyword2":{
                       "value":"' . $time . '",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"请进入微信商城或app查看详情。",
                       "color":"#173177"
                   }
           }
       }';
        $c = $a->curl_post_https($url, $data);
        return $c;
    }


    /**
     * 搜索订单
     * @param $search搜索内容
     * @param $start每页开始
     * @param $limit每页个数
     * @return array
     */
    function order_search($search, $start, $limit, $tpye)
    {


        $admin_user = $_SESSION ["module"]['id'];
        $user = Db::name('admin_user')->where('id', $admin_user)->find();                    //后台登录用户
        $where['sn | username | address_mobile | address_name'] = array('like', "%$search%");            //搜索比对
        if ($tpye == 1) {                                                      //状态
            $where['pay_status'] = '0';
        } elseif ($tpye == 2) {
            $where['pay_status'] = '1';                               //这些判断有些有问题查询数据不对,只需要该查询的$where条件即可
        } elseif ($tpye == 3) {
            $where['confirm_status'] = '2';
        } elseif ($tpye == 4) {
            $where['delivery_time'] = ['<>', '0'];
        } elseif ($tpye == 5) {
            $where['finish_status'] = ['in', ('2')];
        } elseif ($tpye == 6) {
            $where['hd_type'] = ['in', ('1')];
        } elseif ($tpye == 7) {
            $where['hd_type'] = ['in', ('2')];
        } elseif ($tpye == 8) {
            $today = strtotime(date('Y-m-d', time()));         // 当天  0:00
            $today = date('Y-m-d H:i:s', $today);
            $end = strtotime(date('Y-m-d', strtotime('-1 day')));       //前一天 0:00
            $end = date('Y-m-d H:i:s', $end);
            $where['finish_status'] = ['in', ('2')];
            $where['order_time'] = ['not between', "$end,$today"];
        }
        if ($user ["is_supplier"] == 0) {                             //不是商家登录   后台管理员
            $string = 'id,sn,username,address_name,address_mobile,order_time,paid_amount,
            pay_type,pay_sn,groupbuy_id,pay_method,status,pay_status,confirm_status,
            finish_status,pay_time,hd_type';
            $data = listP($string, $where, $start, $limit, $this, false);
        } elseif ($user ["is_supplier"] == 1) {                          //商家登录

        }

//        dump($data);

//        exit;
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }

    /**
     * 发货单搜索
     * @param $search
     * @param $start
     * @param $limit
     * @return array
     */
    function deliver_goods_search($search, $start, $limit)
    {
        $string = 'id,odid,sn,username,address_name,address_mobile,addre_detail,finish_status,status,hd_type';
        $where['sn | username | address_mobile | address_name'] = array('like', "%$search%");
        $where['is_display'] = ['=', '1'];
        $data = listPage($string, $where, $start, $limit, $this, false);
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;

        return $array;
    }

    private function excelType()
    {

    }
}