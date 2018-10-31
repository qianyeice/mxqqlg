<?php
/**
 *
 *  更多分类里面的商品信息
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/10
 * Time: 17:38
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\More_pictures;

class More extends apiController{
    function pictures(){
        $catid=input('catid');
//        $catid=1;
        if(!is_null($catid)){
            $data=new More_pictures();
            $data = $data->Morepictures($catid);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
//        dump($data->Morepictures($catid);
    }

}