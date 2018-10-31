<?php
/**
 *  快递信息
 *
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 11:00
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Details;

class logistics extends apiController{

    function logistics(){

        $order_id = input("post.order_id");

        $data = new Details();

        //        引用dmember_assets方法
        $Success = $data->logistics_details($order_id);
        //        调用返回数据

        return $Success;
    }

///物流详情
    public function cha(){
        //物流号
        $no = input("no");
        //快递公司
        $com = input("com");
        $data = new Details();
        $Success = $data->cha($no,$com);
        return $Success;
    }
}