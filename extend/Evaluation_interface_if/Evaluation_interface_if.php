<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\23 0023
 * Time: 20:51
 */
namespace Evaluation_interface_if;
use app\api\model\Evaluation_page;
class Evaluation_interface_if{
    function judge($member_id,$content,$id){
        if($member_id&&$id){
            if($content!=null){
                $datas=new Evaluation_page();
                $data=$datas->Method($member_id,$content,$id);
                return $data;
            }else{
                $array=array();
                $array["type"]=0;
                $array["lang"]=lang('Hint_is_not_empty');
                $array["data"]=false;
                return $array;
            }
        }else {
            $array["type"]=0;
            $array["lang"]=lang('Hint_is_not_empty');
            return $array;
        }

    }
}