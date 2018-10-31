<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/5/25
 * Time: 10:44
 */

namespace app\api\controller;

namespace app\api\controller;
use app\api\model\GoodsSpu;
use apiController\apiController;

class Novicearea  extends apiController
{
//接口已确认，app+微信，7月17
//新人商城判断用户是否为新人
   public function areacome(){
       $key = input('post.type');
       if(!is_null($key)){
           //   实例化GoodsSpu
           $mod = new GoodsSpu();
           //   调用nowsgoods传递商品ID,获取数据
           $data=$mod->area($key);
           //return DataReturn($shop,'noGoods');//修改
           $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
           return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
       }else{
           return $this->apiReturn(0,lang('faileds'));//返回格式
       }

   }
}