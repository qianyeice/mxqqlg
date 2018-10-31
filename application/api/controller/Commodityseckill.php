<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/22
 * Time: 16:22
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\Seckill;
use app\api\model\Miaosha;

class Commodityseckill extends apiController
{
    /**
     * 秒杀页面时间，场次，商品
     * 程建  2018-3-22 18：:13
     * @return mixed
     */

    public function seckill_Commodity()
    {
      //        实例化Seckill
        $data = new Seckill();

     //       引用seckill_1rmb 方法
        $val = $data->seckill_1rmb();
     //       对时间戳的转化日期
        $seckill = typePdZero($val, array(
            'Screenings_start_time',
            'Screenings_end_time',
            'start_time',
            'end_time'
        ));

     //        $this->apiJournal($seckill);
        return $this->apiReturn($val["type"],$val["lang"],$val["data"]);
    }



    /**
     * 秒杀页面时间，场次，商品
     * 胡焱 2018-5-24
     * @return mixed
     */
    public function Method(){

//      实例化 Miaosha
        $data = new Miaosha();

 //     传参
        $Screenings =input("post.Screenings");

//       引用seckill_spu 方法
        $val = $data->seckill_spu($Screenings);

        //       时间戳的转化 --日期
        $res = typePd($val, array(
            'Screenings_start_time',
            'Screenings_end_time'
        ));
        return $this->apiReturn($res["type"],$res["lang"],$res["data"]);
    }




    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 胡焱
     * 秒杀商品详情
     */
    public function shop()
    {

        //$id 获取商品id
        $id = input('post.id');
        //实例化模型
        $model = new Miaosha();
        //接收数据
        $sql = $model->goods($id);
        //返回数据
        return $this->apiReturn($sql["type"],$sql["lang"],$sql["data"]);
    }


}