<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\20 0020
 * Time: 15:17
 */
namespace app\api\model;
use apiController\apiController;
use think\Model;

class Evaluate extends Model{
    /*
     * @param $member_id：传入用户id
     * @param $spu_id:传入商品id
     * @return 返回查询后结果数组$data
     * 数据库查找当前用户所评价的当前商品
     * Time: 2018\3\20  17:10 name：白锦国
     */
    function Judge($member_id,$spu_id,$order_id){
        $data=$this->query('call evaluate_all('.$member_id.','.$spu_id.','.$order_id.')');
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]=lang('yesEvaluate');

        }else{
            $array["type"]=0;
            $array["lang"]=lang('faileds');
        }
        $array["data"]=count($data);
        return $array;
    }
}