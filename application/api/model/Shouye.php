<?php

namespace app\api\model;

use think\Model;

class Shouye extends Model
{
    /**
     * 首页公告内容获取
     * 龙云飞
     * @return array
     */
    public function gongGao(){
        $data=[
          "content"=>"公告内容"
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

    /**
     * 首页城市汇
     * @return array
     */
    public function cityNav(){

        $data=[
            "city"=>["四川汇","重庆汇","......"],
            "cityId"=>"1"
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

    public function syHuodong(){

        $data=[
            "img"=> "图片url",
            "huodongming"=> "活动名字",
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