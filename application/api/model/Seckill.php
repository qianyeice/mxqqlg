<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/22
 * Time: 15:54
 */
namespace app\api\model;

use think\Model;
use think\Db;

class Seckill extends Model{
    /**
     * 查询秒杀活动页面数据
     * 程建 2018-3-22 18:15
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function seckill_1rmb()
    {
         $data= DB::name("elseseckill")
             ->where("date",date("Y-m-d",time()))
//             ->where('Screenings_start_time','<',time())
//             ->where('Screenings_end_time','>',time())
//             ->where('start_time','<',time())
//             ->where('end_time','>',time())
             ->select();
//         判断时间是否有秒杀商品
         if(count($data)>0){
//             有秒杀商品返回
             return['type'=>1,'data'=>$data,'lang'=>'seckill_Yse'];
         }else{
//             没有秒杀商品返回
             return['type'=>0,'data'=>'','lang'=>'seckill_No'];
         }
    }


}