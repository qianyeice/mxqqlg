<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/22
 * Time: 14:33
 */

namespace app\api\model;

use forloop\forloop;
use think\Db;
use think\Model;

class Memberparent extends Model
{
    /**
     * 我的朋友圈页面数据
     * 冯云祥
     * $id 当前用户的id  $page分页 页数  $type  1：亲朋（下级）   2：铁杆（下下级）  3：推荐人（上级）
     */
    function frienddata($uid,$page,$type)
    {
//        $data = Db::table('member')->where('id', $uid)->find();
//        $data = Db::table('member')->where('id', $data['parent_id'])->find();
        if($type==1){
            if($page==1){
                $data=Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('parent_id',$uid)->limit(0,15)->select();
                $array["type"]=1;
                $array["lang"]=lang('success');
            }else{
                $data=Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('parent_id',$uid)->limit(5*($page-1),15)->select();
                if(count($data)>0){
                    $array["type"]=1;
                    $array["lang"]=lang('success');
                }else{
                    $array["type"]=0;
                    $array["lang"]=lang('faileds');
                }
            }
            $array["data"]=$data;
            return $array;
        }elseif ($type==2){
            $ddd=Db::table('member')->where('parent_id',$uid)->select();
            $data=array();
            $zuihou=array();
            foreach ($ddd as $key=>$v){
                $xiaji=$v['id'];    //当前用户下级id
                $data=Db::table('member')->where('id',$xiaji)->select();    //下级信息
                $id=$data[0]['id']; //下级id
                $xxj=Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('parent_id',$id)->limit(5*($page-1),15)->select(); //下下级信息
                foreach ($xxj as $uu=>$vv){
                    $zuihou[$uu]=$vv;
                }
            }

            if(count($zuihou)>0){
                $array["type"]=1;
                $array["lang"]=lang('success');
                $array["data"]=$zuihou;
            }else{
                $array["type"]=0;
                $array["lang"]=lang('meishuju');
                $array["data"]='';
            }
            return $array;
        }elseif ($type==3){
            $ddd=Db::table('member')->where('id',$uid)->select();
            if($ddd[0]['parent_id']){
                $sji=$ddd[0]['parent_id'];  //上级id
                $data=Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('id',$sji)->select();

                if(count($data)>0){
                    $array["type"]=1;
                    $array["lang"]=lang('success');
                    $array["data"]=$data;
                }else{
                    $array["type"]=0;
                    $array["lang"]=lang('meishuju');
                    $array["data"]='';
                }
            }else{
                $array["type"]=0;
                $array["lang"]=lang('meiparent');
                $array["data"]='';
            }
            return $array;
        }
    }

    /**
     * 我的朋友圈亲朋数据
     * 杜世豪
     * @param $uid 传入用户id
     * @return $data array 亲朋全部数据
     * 18.03.22 15:50
     */
    function relativesdata($uid)
    {
        $data = Db::table('member')->where('parent_id', $uid)->select();
        return $data;
    }

    /**
     * 我的朋友圈铁杆数据
     * 杜世豪
     * @param $uid 传入用户id
     * @return $baby array 铁杆全部数据
     * 18.03.22 16:20
     */
    function Hardcoredata($uid)
    {
        $data = $this->relativesdata($uid);
        $date = '';
        for ($i = 0; $i < count($data); $i++) {
            $date .= $data[$i]['id'] . ',';
        }
        $user = Db::table('member')->select();
        $array = explode(',', $date);
        $for = new forloop();
        $user = $for->gueilei($user);
        $baby = [];
        for ($i = 0; $i < count($array); $i++) {
            $baby[] = $for->guei($user, $array[$i]);
        }
        array_splice($baby,count($baby)-1,1);
        return $baby;
    }

    /**
     * 我的朋友圈搜索功能
     * 杜世豪
     * @param $uid 传入当前用户id
     * @param $distinguish 分辨是搜索亲朋还是铁杆
     * @param $username 搜索的昵称
     * @return $array array 搜索的用户全部数据
     * 18.03.24 10:20
     */
    function search($uid, $distinguish, $username)
    {
        $array = [];
        $p = [];
        // $distinguish分辨是搜索亲朋还是铁杆
        if ($distinguish == 1) {
            $ddd = Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('parent_id', $uid)->where('username', 'like', '%'.$username . '%')->select();
            if(count($ddd) > 0){
                $array["type"] = 1;
                $array["lang"] = lang('success');
                $array["data"] = $ddd;
            }else{
                $array["type"] = 0;
                $array["lang"] = lang('noData');
                $array["data"] = '';
            }
        } elseif ($distinguish == 2) {
            $ddd = Db::table('member')->where('parent_id', $uid)->select();
            foreach ($ddd as $key => $v) {
                $xiaji = $v['id'];    //当前用户下级id
                $data = Db::table('member')->where('id', $xiaji)->select();    //下级信息
                $id = $data[0]['id']; //下级id
                $xxj = Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('parent_id', $id)->where('username', 'like', '%'.$username . '%')->select(); //下下级信息
                foreach ($xxj as $uu => $vv) {
                    $p[$uu] = $vv;
                }
            }
            if(count($xxj) > 0){
                $array["type"] = 1;
                $array["lang"] = lang('success');
                $array["data"] = $xxj;
            }else{
                $array["type"] = 0;
                $array["lang"] = lang('noData');
                $array["data"] = '';
            }

//            $user = Db::table('member')->where('username', 'like', $username . '%')->select();
//            $data = $this->relativesdata($uid);
//            $date = [];
//            for ($i = 0; $i < count($data); $i++) {
//                $date[] = $data[$i]['id'];
//            }
//            for ($i = 0; $i < count($user); $i++) {
//                for ($y = 0; $y < count($date); $y++) {
//                    if ($user[$i]['parent_id'] == $date[$y]) {
//                        $array = $user[$i];
//                    }
//                }
//            }
        } elseif ($distinguish == 3) {
            $ddd = Db::table('member')->where('id', $uid)->select();
            if ($ddd[0]['parent_id']) {
                $sji = $ddd[0]['parent_id'];  //上级id
                $p = Db::table('member')->field('avatar,username,from_unixtime(login_time) as time')->where('id', $sji)->where('username', 'like', '%'.$username . '%')->select();
                if (count($p) > 0) {
                    $array["type"] = 1;
                    $array["lang"] = lang('success');
                    $array["data"] = $p;
                } else {
                    $array["type"] = 0;
                    $array["lang"] = lang('noData');
                    $array["data"] = '';
                }
            }
        }
        return $array;
    }
}