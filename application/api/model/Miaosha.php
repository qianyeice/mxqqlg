<?php
namespace app\api\model;

use think\Model;

class Miaosha extends Model{

    /**
     * 查询秒杀活动页面数据
     * 胡焱
     * @return bool
     */

    function seckill_spu($Screenings)
    {
        $data= $this->where('thumb', '>' ,'' )
            ->where('spu_name', '>' ,'' )
            ->where(' Screenings', '>' ,'' )
            ->where("Screenings",$Screenings)
            ->select();

//         判断时间是否有秒杀商品
        if(count($data)>0){
//             有秒杀商品返回
            return['type'=>1,'data'=>$data->toArray(),'lang'=>'seckill_Yse'];
        }else{
//             没有秒杀商品返回
            return['type'=>0,'data'=>'','lang'=>'seckill_No'];
        }
    }


    function goods($id)
    {
        //数据查询
        $sql = $this->where('spu_id', $id)->select();

        $array=array();
        if(count($sql)>0){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$sql;
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]='';
        }
        return $array;
    }


}
