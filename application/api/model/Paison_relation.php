<?php

namespace app\api\model;

use think\Model;
use think\Db;

class Paison_relation extends Model
{

//    领取新手红包后写入数据
    public function readreds($id, $money)
    {

        $arr = Db::table('paison')->where('member_id', $id)->update(['progress' => 1]);//更改领取状态
        if ($arr == 1) {
            $data = Db::table('member')->where('id', $id)->setInc('money', $money);//加金额；
        } else {
            $data = 0;
        }
        $array = [];
        if ($data == 1 && $arr == 1) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array['data'] = $data;
        } else {
            $array['data'] = '';
            $array["lang"] = 'noData';
            $array["type"] = 0;
        }
     return  $array;


    }

//app微信充值后将用户充值金额写入数据库账户余额
    public function appaddmoney($uid, $money)
    {
        $data = Db::table('member')->where('id', $uid)->setInc('money', $money);//加金额；
        $array = [];
        if ($data == 1) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array['data'] = $data;
        } else {
            $array['data'] = '';
            $array["lang"] = 'noData';
            $array["type"] = 0;
        }
        return  $array;


    }



// 接受 红包任务是否完成
    public function redtasks($id)
    {
        $datas = Db::table('member')
            ->alias('m')
            ->where('m.parent_id', $id)
            ->column('id');

        if(count($datas)>0){
            $table = Db::table('order');
            $where = 'buyer_id in (';
            for ($i = 0; $i < count($datas); $i++) {
                $where .= $i < count($datas) - 1 ? $datas[$i] . ',' : $datas[$i];
            }
            $where .= ')';
            $table = $table->where($where);
            $arrs = $table->where('pay_status', 1)->group('buyer_id')->order('id')->limit(3)->select();
            if (count($arrs) > 0) {
                $where = 'id in (';
                for ($i = 0; $i < count($arrs); $i++) {
                    $where .= $i < count($arrs) - 1 ? $arrs[$i]['buyer_id'] . ',' : $arrs[$i]['buyer_id'];
                }
                $where .= ')';
                $arrs = Db::table('member')->where($where)->select();
                $array = [];
                if (count($arrs) == 0) {
                    $array["type"] = 0;
                    $array["lang"] = 'noData';
                    $array["data"] = $arrs;
                } else {
                    $array["type"] = 1;
                    $array["lang"] = 'success';
                    $array["data"] = $arrs;
                }
            } else {
                $array["type"] = 0;
                $array["lang"] = 'noData';
                $array["data"] = $arrs;

            }
        }else{
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = 1;
        }

        return $array;
    }
    /**
     * @param $pid paison 表id
     * @param $jid 加入者的id
     * @return array 返回是否成功
     * 丁龙
     * 18.3.27
     * 16:58
     */
//    public function red($pid, $jid)
//    {
//
//        if (!($this->where('paison_id', $pid)->select()->count() >= 3)) {
//            $jg = $this->insert(array(
//                'paison_id' => $pid,
//                'join_id' => $jid
//            ));
//            return array(
//                'type' => $jg,
//                'data' => '',
//                'lang' => 'add_failure'
//            );
//
//        } else {
//            return array(
//                'type' => 0,
//                'data' => '',
//                'lang' => 'rssx'
//            );
//        }
//    }

    public function red($id)
    {

        $con = Db::name('order')
            ->where('buyer_id', $id)
            ->select();
        if (count($con) > 0) {
            $data = Db::name('Paison')
                ->where('member_id', $id)
                ->select();
            if (count($data) == 0) {
                $sql = ['member_id' => $id, 'progress' => 0];
                Db::name('Paison')->insert($sql);
                $data = Db::name('Paison')
                    ->where('member_id', $id)
                    ->select();
                return array(
                    'type' => 1,
                    'data' => $data,
                    'lang' => '老用户'
                );
            } else {
                return array(
                    'type' => 1,
                    'data' => $data,
                    'lang' => '老用户'
                );
            }
        } else {
            return array(
                'type' => 1,
                'data' => 'new',
                'lang' => '新用户'
            );
        }
    }

    public function reder($id)
    {
        $arr = [];
        for ($i = 0; $i < count($id); $i++) {
            $arr[$i] = Db::table('member')->field("username,avatar")->where('id', $id[$i])->find();
        }
        return array(
            'type' => 1,
            'data' => $arr,
            'lang' => '用户'
        );

    }

    public function _complete($id)
    {

    }

}