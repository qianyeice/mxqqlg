<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/22
 * Time: 10:27
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\PanicCommodity;

class Promotionpanic extends apiController
{
    /**判断商品是否为促销商品
     * 程建 2018-3-22 10：52
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function panic_commodity()
    {
//        接受POST传值地标spu_id商品ID
        $id = input('post.spu_id');
//        实例化modelPanicCommodity,
        $data = new PanicCommodity();
//        调用Panic_promotion传递商品id
        $val = $data->Panic_promotion($id);
//        // 操作写入日志
//        $this->apiJournal($val);
        var_dump($val);
        return $this->apiReturn($val["type"],$val["lang"],$val["data"]);
    }
}