<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2018/5/31
 * Time: 16:20
 */

namespace app\api\model;

use think\Db;
use think\model;

class Placeorder extends model
{
    public function first($buyer,$real,$name,$mobile,$detail)
    {

        $data = [
            "sn" => "20180320143629100507",
            "buyer_id" =>$buyer,
            "pay_type" => 1,
            "real_amount"=>$real,
            "address_name"=>$name,
            "address_mobile"=>$mobile,
            "addre_detail"=>$detail,
            "status"=>4,
            "pay_status"=>0,
            "order_time"=>date("Y-m-d H:i:s",time())
        ];

        $res = Db::name("order")->insert($data);

        $array = array();
        if($res){
            $array["type"]=1;
            $array["lang"]='Add_success';
            $array["data"]=$res;
        }else{
            $array["type"]=0;
            $array["lang"]='Add_failure';
            $array["data"]="";
        }

        return $array;

    }
}