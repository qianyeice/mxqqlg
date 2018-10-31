<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 15:11
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Member;
use think\Db;

class Menber extends apiController
{
    public function index()
    {
        $uid = input('uid');
        $d = $this->getusers(array($uid));
        $data = Db::table('order')->where('buyer_id', 'in', $d)->sum('paid_amount');
        $usedata = Db::table('order')->where('buyer_id', 'in', $d)->where('status', '0')->sum('paid_amount');
        $dream = Db::table('member')->alias('m')
            ->where('m.id', $uid)
            ->join('user_grade u', 'm.is_special=u.id', 'left')
            ->field('m.id,m.username,u.grade,u.bili')
            ->select();
        $data = array(
            'data' => $data,
            'usedata' => $usedata,
            'count'=>count($d),
            'dream' => $dream,

        );
        return $data;
    }

    function getusers($userid)
    {
        $uids = array();
        while (count($userid) != 0) {
            $data = Db::table('member')->field('id')->where('parent_id', 'in', $userid)->cache(7200)->select();
            $data = array_column($data, 'id');
            $da = array_intersect($uids, $data);
            if (count($da) != 0) {
                $data = array_diff($data, $da);
            }
            $userid = $data;
            $uids = array_merge($uids, $userid);
        }
        return $uids;
    }
    function menber_write(){

        $id=input('post.id');
        $vipa=input('post.vipa');
        if(!is_null($id) || !is_null($vipa)){
            $table = new Member();
            $data = $table->memberwrite($id,$vipa);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

}