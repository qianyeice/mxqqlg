<?php
/**
 * Created by PhpStorm.
 * User: 李磊
 * Date: 2018/4/13
 * Time: 10:49
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Founder extends Model
{
    /**
     * 发起人信息遍历
     * 吴杰
     * @param $start
     * @param $limit
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public function To_grant_authorization($start, $limit)
    {
        if ($limit == 0 && $start == 0) {
            $data = $this
                ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
                ->where("grade_id", "3")
                ->where("is_impower", "1")
                ->where("is_tr", "0")
                ->select();
        } else {
            $data = $this
                ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
                ->where("grade_id", "3")
                ->where("is_impower", "1")
                ->where("is_tr", "0")
                ->page($start, $limit)
                ->select();
        }

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function deleup($id)
    {
        $date = Db::table("founder")
            ->where("id",'in',$id)
            ->update(["is_delete" => 1]);
        return $date;
    }

    //坐席分成权限添加级修改        陈建英
    public function adder($id, $content)
    {
        $pd = Db::table("use_h")->where("member_id", $id)->where("is_delete", '0')->where("is_impower", '1')->find();
        if ($pd) {
            $data = Db::table("use_h")->where("member_id", $id)->update(["grade_id" => $content]);
        } else {
            $add['member_id'] = $id;
            $add['grade_id'] = $content;
            $add['go_time'] = time();
            $add['address'] = '中国';
            $add['is_impower'] = '1';
            $add['is_delete'] = '0';
            $data = Db::table("use_h")->insert($add);
        }

        return $data;
    }

    public function add($name)
    {
        $data = Db::table("member")
            ->where("username", $name)
            ->whereOr("mobile", $name)
            ->field("id,username,avatar")
            ->select();
        return $data;
    }

    public function impower($start, $limit)
    {

            $data['count'] = $this
                ->field("username,mobile,email,member_id,avatar,address,grade,go_time,address,order")
                ->where("is_delete", "0")
                ->where("is_impower", "0")
                ->count();

            $data['data'] = $this
                ->field("username,mobile,email,member_id,avatar,address,grade,bili,go_time,address,order")
                ->where("is_delete", "0")
                ->where("is_impower", "0")
                ->page($start, $limit)
                ->select();

         return $data;

    }

    public function imxiu($id)
    {
        $data = Db::table("use_h")
            ->where("member_id", 'in', $id)
            ->update(["is_impower" => 1]);
        return $data;
    }

    public function selec($content)
    {
        $data = $this
            ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
            ->where("grade_id='3' and username='$content' or mobile='$content' or email='$content'")
            ->select();
        return $data;
    }
}
