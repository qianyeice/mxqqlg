<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 15:47
 */

namespace app\api\model;

use think\Model;

class Img extends Model
{
    /**首页轮播图
     * 龙云飞
     * @return array
     */
    public function syLunbo(){

        $data=[
            "img"=>"图片url",
            "chanpinid"=>"1",//产品id
        ];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"]=$data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'defeated';
        }
        return $array;
    }
}