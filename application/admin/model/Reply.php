<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/14
 * Time: 14:04
 */

namespace app\admin\model;
use think\Model;
use think\Db;

class Reply extends Model
{
    function sel()
    {
        $que = $this->select();

        return $que;
    }

    function adds($id,$reply)
    {
        if($reply==""){
            return 2;
        }else{
            $data = ['reply'=>$reply,'is_shield'=>'1'];
            $plyre = Db::table('comment')->where('id',$id)->update($data);
            return $plyre;
        }

    }

    function dele($id)
    {
        $dete = Db::table('comment')->where('id','in',$id)->delete();

        return $dete;
    }

    /**
     * 吴杰
     * 评论列表搜索功能
     * @param $start
     * @param $end
     * @param $spinner
     * @param $keyword
     * @return false|\PDOStatement|string|\think\Collection
     */
    function search($start,$end,$spinner,$keyword)
    {

        if ($start == null && $end == null && $spinner == null && $keyword == null) {
            $que = $this->select();
            return $que;
        } else if ($start == null && $end != null) {
            $que = $this
                ->where("datetime", "<", $end)
                ->whereOr("username", $keyword)
                ->whereOr("is_shield", $spinner)
                ->select();
            return $que;
        }else if ($start != null && $end == null) {
            $que = $this
                ->where("datetime", ">", $start)
                ->whereOr("username", $keyword)
                ->whereOr("is_shield", $spinner)
                ->select();
            return $que;
        }else if ($start != null && $end != null) {
            $que = $this
                ->where("datetime",">",$start)
                ->where("datetime","<",$end)
                ->whereOr("username", $keyword)
                ->whereOr("is_shield", $spinner)
                ->select();
            return $que;
        }else{
            $que = $this
                ->where("username", $keyword)
                ->whereOr("is_shield", $spinner)
                ->select();
            return $que;
        }
    }}