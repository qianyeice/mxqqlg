<?php
/**
 *   积分明细
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 10:12
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Queryintegral;

/**
 * Class Integraldetail
 * @package app\api\controller
 *
 *
 */

class Integraldetail extends apiController{

    function detail(){
        //   接受用户ID member_id
        $member_id = input("post.member_id");
        $startlimit = input("startlimit");
        $endlimit = input("endlimit");
        //   实例化 Queryintegral
        $data = new Queryintegral();

        //  调用Query_integral方法
        $Query = $data->query_integral($member_id,$startlimit,$endlimit);

        //   时间戳转化日期
        $res = typePdZero($Query, array('time'));

        return $res;

        
    }
}