<?php
/**
 * Created by PhpStorm.
 * 说明：用户上下级
 * User: 杜世豪
 * Date: 2018/3/22
 * Time: 11:43
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Memberparent;
use forloop\forloop;

class Menberparent extends apiController
{
    /**
     * 我的朋友圈页面数据
     * 冯云祥
     * $id 当前用户的id  $page分页 页数  $type  1：亲朋（下级）   2：铁杆（下下级）  3：推荐人（上级）
     */
    function frienddata()
    {
        $id=input('id');
        $page=input('page');
        $type=input('type');
        if(!is_null($id)&&!is_null($page)&&!is_null($type)){
            $member = new Memberparent();
            $data = $member->frienddata($id,$page,$type);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    /**
     * 我的朋友圈页面的亲朋数据
     * 杜世豪
     * @return  array 亲朋数据
     * 18.03.22 15:50
     */
    function relativesdata()
    {
        $member = new Memberparent();
        // input()是当前用户的id
        $data = $member->relativesdata(input('id'));
        $type = 0;
        $data ? $type = 1 : $type = 0;
        return $this->apiReturn($type, lang('noRelatives'), $data);
    }

    /**
     * 我的朋友圈页面的铁杆数据
     * 杜世豪
     * @return  array 铁杆数据
     * 18.03.22 15:50
     */
    function Hardcoredata()
    {
        $member = new Memberparent();
        // input()是当前用户的id
        $data = $member->Hardcoredata(input('id'));
        $type = 0;
        $data ? $type = 1 : $type = 0;
        return $this->apiReturn($type, lang('noHardcore'), $data);
    }

    /**
     * 我的朋友圈页面的搜索功能
     * 杜世豪
     * @return  array 用户数据
     * 18.03.24 09:50
     */
    function search()
    {
        $uid = input('uid');
        $type = input('type');
        $username = input('username');
        if(!is_null($uid)&&!is_null($type)&&!is_null($username)){
            $member = new Memberparent();
            // 分辨是搜索亲朋还是铁杆
            $data = $member->search($uid,$type,$username);
            $data ? $type = 1 : $type = 0;
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}