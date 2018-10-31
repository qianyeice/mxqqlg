<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/20
 * Time: 14:46
 */

namespace app\api\controller;

use app\api\model\GoodsSku;
use app\api\model\GoodsSpu;
use apiController\apiController;


/**
 * 方法名 goods_shows（）商品详情
 * @param $id 用户ID  $model   $sql   DataReturn
 * @return mixed 返回查询到的数据或者对应的语言包
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * 岳军章
 * 18.3.20 :14:20
 */
class GoodsSpus extends apiController
{
    public function goods_shows()
    {
        //$id 获取商品id
        $id = input('id');

        //实例化模型
        $model = new GoodsSpu();
        //接收数据
        $sql = $model->goods_show($id);
        //返回数据
        return $this->apiReturn($sql["type"], $sql["lang"], $sql["data"]);
    }


    public function fly()
    {
        $id = input('id');
        if(!is_null($id)){
            $model = new GoodsSpu();
            //接收数据
            $data = $model->test($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else {
            return $this->apiReturn(0, lang('faileds'));//返回格式
        }
    }
    public function flash_sale()
    {
        $id = input('id');
        $rush = input('rush_id');
        if(!is_null($id)&&!is_null($rush)){
            $sp = new GoodsSpu();
            $data = $sp->toFlash($rush,$id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    /**
     * 查询商品规格详情,轮播图
     * time:18-6-20 14:34
     * author:冯云祥    spu_id商品id
     */
    public function goods()
    {
        $id = input('spu_id');
        if(!is_null($id)){
            $model = new GoodsSku();
            $data = $model->goods($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    //陈健英    商品详情轮播图
    public function lun()
    {
        $id = input('spu_id');
        $new = new GoodsSpu();
        $img = $new->lun($id);
        return $this->apiReturn($img["type"], $img["lang"], $img["data"]);

    }

    //邓强  多商品的查询
    public function Multi_commodity()
    {
        $gwid = input('shop_id');
        $sid = input('id');
        if(!is_null($gwid)&&!is_null($sid)){
            $id = explode('.', $sid);
            $gid = explode('.', $gwid);
            //实例化模型
            $model = new GoodsSpu();
            //接收数据
            $data = $model->Multi_commodity($id, $gid);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
//  邓强  查询商品id数量
//     public function Multi_shop(){
//
//
//    //实例化模型
//    $model = new GoodsSpu();
//    //接收数据
//    $sql = $model->Multi_shop($id);
//    //返回数据
//
//    return $this->apiReturn($sql["type"],$sql["lang"],$sql["data"]);
//}
//商品规格价格图片
    public function spec_Price(){
        $id=input("id");
        if(!is_null($id)){
            //实例化模型
            $model = new GoodsSpu();
            //接收数据
            $data = $model->spec_Price($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

}