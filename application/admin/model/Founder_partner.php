<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/4/27
 * Time: 21:23
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Founder_partner extends Model
{
    /**
     * 合伙人信息遍历
     * 吴杰
     * @param $start
     * @param $limit
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public function To_partner_authorization($start, $limit, $type, $sou)
    {

if($sou){
    $data['count'] = Db::table("founder")
        ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
        ->where("grade_id", $type)
        ->where("is_impower", "1")
        ->where("is_delete", "0")
        ->where("username", "=", $sou)
        ->whereOr("mobile","=",$sou)
        ->count();

    $data['data'] = Db::table("founder")
        ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
        ->where("grade_id", $type)
        ->where("is_impower", "1")
        ->where("is_delete", "0")
        ->where("username", "=", $sou)
        ->whereOr("mobile","=",$sou)
        ->page($start, $limit)
        ->select();
}else{
    $data['count'] = Db::table("founder")
        ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
        ->where("grade_id", $type)
        ->where("is_impower", "1")
        ->where("is_delete", "0")
        ->count();

    $data['data'] = Db::table("founder")
        ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
        ->where("grade_id", $type)
        ->where("is_impower", "1")
        ->where("is_delete", "0")
        ->page($start, $limit)
        ->select();
}


        return $data;
    }


    public function deleup($id)
    {
        $date = Db::table("member")
            ->where("id", 'in', $id)
            ->update(["is_special" => 0]);
        return $date;
    }

    public function adder($id, $content)
    {

        $data = Db::table("use_h")
            ->where("member_id", $id)
            ->update(["grade_id" => $content]);
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
        if ($limit == 0 && $start == 0) {
            $data = $this
                ->field("username,mobile,email,member_id,avatar,address,grade,go_time,address,order")
                ->where("is_delete", "0")
                ->where("is_impower", "0")
                ->select();
        } else {
            $data = $this
                ->field("username,mobile,email,member_id,avatar,address,grade,bili,go_time,address,order")
                ->where("is_delete", "0")
                ->where("is_impower", "0")
                ->limit($start, $limit)
                ->select();
        }

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function imxiu($id)
    {
        $data = Db::table("use_h")
            ->where("member_id", $id)
            ->update(["is_impower" => 1]);
        return $data;
    }

    public function selec($content)
    {
        $data = Db::table("founder")
            ->field("id,username,mobile,email,avatar,grade,bili,go_time,address,member_id")
            ->where("grade_id='2' and username='$content' or mobile='$content' or email='$content'")
            ->select();

        return $data;
    }
}
