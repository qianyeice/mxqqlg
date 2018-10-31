<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/20
 * Time: 16:56
 */

namespace app\api\controller;
use apiController\apiController;
use \app\api\model\GoodsSpu;
class CommodityJudge extends apiController
{
    /**
     * 商品详情页面判断商品类型新手 秒杀
     * 程建
     * 18-3-20 17：27
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function judge()
    {
        //        接受POST传值地标spu_id商品ID
        $id=input('post.spu_id');
        //   实例化GoodsSpu
        $data = new  GoodsSpu();
        //   调用judge传递商品ID
        $type = $data->judge($id);
        //        判断商品新手，秒杀
        if ($type['type'] == 1) {
        //            商品为新手
             if($type['data']['type']== 1){
                return ['type' => 1,'explain'=>lang('novice_commodity')];
            }
            if ($type['data']['type'] == 2) {
        //            商品为秒杀
                return ['type' => 2,'explain'=>lang('seckill_commodity')];
            }
        } else{
            return $this->apiReturn($type["type"],$type["lang"],$type["data"]);
        }
    }
}