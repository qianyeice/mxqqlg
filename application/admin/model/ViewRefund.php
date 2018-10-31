<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/7
 * Time: 10:39
 */

namespace app\admin\model;

use think\Model;

class ViewRefund extends Model
{
    /**
     * 退款单管理
     * 程建 2018-4-7 11：:19
     * @param $type
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function refund_manage($type,$page,$count)
    {
        $string='id,username,paid_amount,goods_name,choose,spec,type,refund_time,goods_url';
        if($type==1){
             $select['type']=['=','1'];
             $data=listPage($string, $select, $page, $count, $this,false);
        }elseif ($type==2){
            $select['type']=['=','0'];
            $data=listPage($string, $select, $page, $count, $this,false);
        }else{
            $data=listPage($string, '', $page, $count, $this,false);
        }
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'refund';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
        }
        $array["data"] = $data;
        return $array;
    }

    /**
     * 退货单管理
     * 程建 2018-4-7 11:34
     * @param $type
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function return_goods_manage($type,$page,$count)
    {
        $string='id,username,paid_amount,goods_name,choose,spec,type,refund_time,goods_url,return_logistics,return_number ';
        $select['choose']=['=','1'];
        if($type==1){
            $select['type']=['=','1'];
            $data=listPage($string, $select, $page, $count, $this,false);
        }elseif ($type==2){
            $select['type']=['=','0'];
            $data=listPage($string, $select, $page, $count, $this,false);
        }else{
            $select['choose']=['=','1'];
            $data=listPage($string, $select, $page, $count, $this,false);
        }
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] =lang('return_goods');
        } else {
            $array["type"] = 0;
            $array["lang"] =lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }

    /**
     * 退款退货处理
     * @param $id退款ID
     * @param $type处理状态
     * @param $text操作备注
     * @return array
     */
    function refund_handle($id,$type,$text)
    {
      $data=$this->where('id',$id)->update(['type' => $type,'operating_notes'=>$text]);
        $array = array();
      if($data){
          $array["type"] = 1;
          $array["lang"] = lang('success');
      }else{
          $array["type"] = 0;
          $array["lang"] =  lang('noData');
      }
        return $array;
    }

    /**
     * 退款单搜索
     * @param $search
     * @param $start
     * @param $limit
     * @return array
     */
    function refund_search($search,$start,$limit)
    {
        $string='id,username,paid_amount,goods_name,choose,spec,type,refund_time,goods_url';
        $where['username | goods_name'] = array('like', "%$search%");
        $data = listPage($string, $where, $start, $limit, $this,false);
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }
    /**
     * 退货单搜索
     * @param $search
     * @param $start
     * @param $limit
     * @return array
     */
    function return_goods_search($search,$start,$limit)
    {
        $string='id,username,paid_amount,goods_name,choose,spec,type,refund_time,goods_url';
        $where['username | goods_name'] = array('like', "%$search%");
        $data = listPage($string, $where, $start, $limit, $this,false);
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }
}