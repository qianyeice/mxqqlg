<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 11:30
 */
namespace carousel;
use think\Cache;
class carousel {

    /**
     * 主页轮播图 数据结果返回处理
     * time：18-3-20 11：34
     * author：陈明福
     * @param $data 数据库查询的数据包
     * @return mixed 返回处理过的数据
     */
    public function HomeCarouselHandle($data){
        //判断是否有数据
        if(count($data)>0){
            return $data;
        }else{
            return false;
        }
    }
}