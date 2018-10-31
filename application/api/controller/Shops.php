<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/24
 * Time: 16:34
 */

namespace app\api\controller;
use app\api\model\Shop;
use apiController\apiController;

class Shops extends apiController
{
    /**
     * 添加购物车  append()
     * @param  $data 获取input值
     * @param $rlsts 接收数据
     * @return return 返回数据
     * name 岳军章
     * time 2018/3/27 9：00
     */
    public function append()
    {

        //获取input值
        $data['member_id']= input('member_id');
        $data['spu_id']= input('spu_id');
        $data['sku_id']= input('sku_id');
        $data['number']=input('number');
        $data['fc_type']=input('fc_type');

        //实例化模型
        $model = new Shop();

        //接收数据
      $rlts = $model->Shop_append($data);
        //返回
     $this->apiJournal($rlts["type"], $rlts["lang"], $rlts["data"]);//日志
    return $this->apiReturn($rlts['type'],$rlts['lang'],$rlts['data']);

    }

}