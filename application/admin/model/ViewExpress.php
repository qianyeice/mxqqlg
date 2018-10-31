<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/8
 * Time: 10:05
 */

namespace app\admin\model;
use think\Model;

class ViewExpress extends Model
{
    /**
     * 快递单管理
     * 程建 2018-4-8 10:26
     * @param $type
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function express($type,$page,$count)
    {
        $string='id,sn,delivery_name,delivery_sn,delivery_time,isreceive,receive_time,print_time,print_type';
        if($type==1){
            $select['print_type']=['=','0'];
            $data=listPage($string, $select, $page, $count, $this,false);
        }elseif ($type==2){
            $select['print_type']=['=','1'];
            $data=listPage($string, $select, $page, $count, $this,false);
        }else{
            $data=listPage($string, '', $page, $count, $this,false);
        }
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]='refund';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;
        return $array;
    }
}