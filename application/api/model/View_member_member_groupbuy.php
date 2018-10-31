<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/27
 * Time: 14:31
 */

namespace app\api\model;

use function GuzzleHttp\Psr7\_caseless_remove;
use think\Db;
use think\Model;

class View_member_member_groupbuy extends Model
{
    /**
     * 查找当前商品的团
     * time ：18-3-27 14:56
     * author :冯云祥
     * @param $goodsID 商品id
     * @return array 状态数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function commodityGroupInquiry($goodsID)
    {
        //定义查询条件组
        $data = [
            "sku_id" => $goodsID,
        ];


        $data = $this->field("id,groupbuy_id,member_id,sku_id,join_time,username,avatar,is_leader,max_num")->where($data)->select();

        $array = array();
        foreach ($data as $key => $v) {
            if (strtotime($v['join_time']) + 86400 > time()) {    //没过期的团购
                $array[$key] = $v->toArray();
            }
        }
        if (count($array) == 0) {
            $aaa["type"] = 0;
            $aaa["lang"] = lang('error');
            $aaa["data"] = '';

        } else {
            $d = array();
            foreach ($array as $vv) {
                if ($vv['is_leader'] == 1) {
                    foreach ($vv as $k => $v) {
                        $d[$vv['groupbuy_id']][$k] = $v;
                    }
                    $end_time = ((strtotime($vv['join_time']) + 86400) - time());
//
                    $d[$vv['groupbuy_id']]['hours'] = floor($end_time / 3600);//剩余小时
                    $d[$vv['groupbuy_id']]['min'] = floor($end_time % 3600 / 60);//剩余分钟数
                }
                $d[$vv['groupbuy_id']]['count'] = isset($d[$vv['groupbuy_id']]['count']) ? $d[$vv['groupbuy_id']]['count'] + 1 : 1;
            }
            $aaa["type"] = 1;
            $aaa["lang"] = lang('success');
            $aaa["data"] = $d;
        }
        return $aaa;
    }


    public function team($team, $id)
    {
        $data = [
            'groupbuy_id' => $team,
            'buyer_id' => $id,

        ];
        $count = Db::table('order')->where($data)->select();

        if (count($count) == 0) {
            $array["type"] = 0;
            $array["lang"] = lang('error');
            $array["data"] = $count;
        } else {
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $count;
        }
return $array;

    }

}