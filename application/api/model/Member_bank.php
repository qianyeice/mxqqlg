<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/24
 * Time: 14:42
 */

namespace app\api\model;

use think\Db;
use think\Model;

class Member_bank extends Model
{


    /**
     * 银行卡页面所有银行卡接口
     * 杜世豪
     * @param $uid '传入用户id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *  18.03.24 15:20
     */
    function showall($uid)
    {
        $data = $this->where('mid', $uid)->where('is_delete', 1)->select();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
            $array["data"] = '';
        }
        return $array;

    }

    //银行卡编号详见  微信提现银行及编号.xlsx

    /**
     * 杜世豪
     * @param $uid 传入用户id
     * @param $name 传入用户真实姓名
     * $code 用户收到的验证码
     * $yzm  发送出的验证码
     * @param $bank_number 银行卡号
     * @return int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 18.03.24 15:20  改于18.7.25
     */
    function Addbankcard($uid, $name, $code, $bank_number, $yzm)
    {
        $array = [];
        if ($code != $yzm) {
            $array["type"] = 0;
            $array["lang"] = lang('duanxin2');
            $array["data"] = "";
        } else {
            $default = $this->where('mid', $uid)->select();
            $card = [
                'mid' => $uid,
                'name' => $name,
                'bank_no' => $bank_number
            ];
            if (count($default) > 0) {
                $card['id_default'] = 0;
            } else {
                $card['id_default'] = 1;
            }
            $data = Db::table('member_bank')->insert($card);
            if ($data) {
                $array["type"] = 1;
                $array["lang"] = lang('success');
                $array["data"] = "";
            } else {
                $array["type"] = 0;
                $array["lang"] = lang('faileds');
                $array["data"] = $data;
            }
        }

        return $array;

    }

    /**
     * 编辑银行卡接口
     * 杜世豪
     * @param $id '传入需要修改的银行卡的id
     * @param $name '传入用户真实姓名
     * @param $bank_name '银行名称
     * @param $bank_no '银行卡号
     * @param $bank_id 微信银行卡编号{2018.5.12:张平添加}
     * @return $this
     * 18.03.24 15:50
     */
    function Editbankcard($id, $name, $bank_name, $bank_no, $bank_id)
    {
        $card = [
            'name' => $name,
            'bank_name' => $bank_name,
            'bank_no' => $bank_no,
            'bank_id' => $bank_id,
        ];
        $data = $this->where('id', $id)->update($card);
        return $data;
    }

    /**
     * 编辑默认银行卡接口
     * 杜世豪
     * @param $id '传入需要修改的银行卡的id
     * @return $data array 编辑默认银行卡成功与否的type
     * 18.03.24 15:50
     */
    function Setdefault($id, $mid)
    {

        $Set = $this->where('mid', $mid)->update(['id_default' => '0']);
//        if($Set){
//        }
        $data = $this->where('id', $id)->update(['id_default' => '1']);
        return $data;
    }

    /**
     * 删除银行卡接口
     * 杜世豪
     * @param $id '传入需要删除的银行卡的id
     * @return $data array 删除成功与否的type
     * 18.03.24 15:50
     */
    function Deletedefault($id)
    {
        $data = $this->where('id', $id)->update(['is_delete' => '0']);
        return $data;
    }


//    app提现接口
    function tixian($id, $money, $Presentation_mode, $Account_number)
    {
        if ($Presentation_mode == "wechat") {
            $Order_number = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);//生成订单号
            $d = ['mid' => $id, 'wtype' => 0, 'amount' => $money, "applytime" => date("Y-m-d H:i:s", time()), "type" => 0,
                "ordernum" => $Order_number, "poundage" => ($money * 0.001)];
            $q = Db::name("withdraw")->insert($d);
            if($q){
                $allmoney=Db::table('member')->field('money')->where("id",$id)->select();
                $yuan=floatval($allmoney[0]['money'])-floatval($money);
                Db::table('member')->where("id",$id)->update(['money'=>$yuan]);
            }
            if ($q) {
                $array["type"] = 1;
                $array["lang"] = '订单提交成功';
                $array["data"] = $q;
            }else {
                $array["type"] = 0;
                $array["lang"] = '订单提交失败';
                $array["data"] = 0;
            }
        } else if ($Presentation_mode == "Bank_card") {
            $Order_number = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);//生成订单号
            $d = ['mid' => $id, 'wtype' => 1, 'amount' => $money, "applytime" => date("Y-m-d H:i:s", time()), "type" => 0,
                "ordernum" => $Order_number, "poundage" => ($money * 0.001), "banknum" => $Account_number];
            $q = Db::name("withdraw")->insert($d);
            if($q){
                $allmoney=Db::table('member')->field('money')->where("id",$id)->select();
                $yuan=floatval($allmoney[0]['money'])-$money;
                Db::table('member')->where("id",$id)->update(['money'=>$yuan]);
            }
            if ($q) {
                $array["type"] = 1;
                $array["lang"] = '订单提交成功';
                $array["data"] = $q;
            }else {
                $array["type"] = 0;
                $array["lang"] = '订单提交失败';
                $array["data"] = 0;
            }
        } else {
            $array["type"] = 0;
            $array["lang"] = '订单提交失败';
            $array["data"] = 0;
        }
        return $array;
    }

    public function BankCardAdd($uid, $name, $bank_name, $bank_no, $bank_id)
    {
        $array=[];
        $val =Db::table("member_bank")->where('mid', $uid)->select();
        $bankNo =Db::table("member_bank")->where('bank_no', $bank_no)->select();
//        dump($val);exit;

        if($val){
            $id_default=0;
        }else {
            $id_default=1;
        }
        if ($bankNo) {
            $array["type"] = 0;
            $array["lang"] = '银行卡已存在';
            $array["data"] = '';
        } else {
            $con = [
                "mid" => $uid,
                "bank_no" => $bank_no,
                "bank_name" => $bank_name,
                "name" => $name,
                "bank_id" => $bank_id,
                "is_delete"=>1,
                "id_default"=>$id_default,
            ];
            $data = Db::table("member_bank")->insert($con);
            if ($data) {
                $array["type"] = 1;
                $array["lang"] = '添加成功';
                $array["data"] = '';
            } else {
                $array["type"] = 0;
                $array["lang"] = '添加失败';
                $array["data"] = '';
            }
        }


        return $array;
    }

}