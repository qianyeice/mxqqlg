<?php
/**
 * 银行卡默认卡
 *
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 13:27
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Default_card;

class Defaultcard extends apiController{

    function card(){

        $mid = input("post.mid");

        $data=new Default_card();

        return $data->card($mid);
    }

    /**
     * 邓强
     * 修改默认银行卡
     *  $id 用户id
     * $bank_no 卡号参数
     * @return string 返回值
     */
    function upbank(){

        $bank_no = input("bank_no");
        $id= input("id");

        $data=new Default_card();

        return $data->upbank($bank_no,$id);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

}