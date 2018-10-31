<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class View_divlog extends Model
{
    /**
     * time:18-4-25 16.20
     * name:邓剑
     * 用户分红数据
     * @param $mgid 会员等级表的id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryall($mgid,$start,$limit,$name=null,$begin=null, $end=null)
    {
        $_is=' and d.is_delete in ("1")';
        if (!empty($begin)) {
            $begin=strtotime($begin);
            $begin = ' and unix_timestamp(d.time)>' . $begin;
        } if (!empty($end)) {
        $end=strtotime($end);
        $end = ' and unix_timestamp(d.time)<' . $end;
    } if (!empty($name)) {
        $name = ' and (m.username like "%' . $name . '%")';
    }
        $w['data']=$this->query('select m.username,d.time,d.money,d.channel,d.member_id,d.is_delete from dividend_log as d JOIN member as m ON d.member_id=m.id
        where d.member_group_id='.$mgid.$_is.$begin.$end.$name.' ORDER BY d.id DESC limit '.$start.','.$limit);
        $w['count']=$this->query('select m.username,d.time,d.money,d.channel,d.member_id,d.is_delete from dividend_log as d JOIN member as m ON d.member_id=m.id
        where d.member_group_id='.$mgid.$_is.$begin.$end.$name.' ORDER BY d.id DESC');
        return $w;
    }

    function sel($name, $begin, $end, $mgid)
    {
        if ($name == '' && $begin == '' && $end == '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->select();
        } else if ($name != '' && $begin == '' && $end == '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('m_name', 'like', '%' . $name . '%')->select();
        } else if ($name == '' && $begin != '' && $end != '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('d_time', '>', $begin)->where('d_time', '<', $end)->select();
        } else if ($name != '' && $begin != '' && $end != '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('d_time', '>', $begin)->where('d_time', '<', $end)->where('m_name', 'like', '%' . $name . '%')->select();
        } else if ($name == '' && $begin != '' && $end == '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('d_time', '>', $begin)->select();
        } else if ($name == '' && $begin == '' && $end != '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('d_time', '<', $end)->select();
        } else if ($name != '' && $begin != '' && $end == '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('d_time', '>', $begin)->where('m_name', 'like', '%' . $name . '%')->select();
        } else if ($name != '' && $begin == '' && $end != '') {
            return $this->where('d_is_delete', '1')->where('d_mgid', $mgid)->where('d_time', '<', $end)->where('m_name', 'like', '%' . $name . '%')->select();
        }
    }
}