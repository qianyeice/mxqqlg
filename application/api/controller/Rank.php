<?php
namespace app\api\controller;

use apiController\apiController;
use app\api\model\view_group;

class Rank extends apiController{

    /**
     * @return array
     * 胡焱
     * 用户的VIP等级 + 进度值
     */

    public function person_member()
    {
        $mid = input('post.mid');
        $with = new view_group();
        $table = $with ->draw($mid);
return $this->apiReturn($table["type"],$table["lang"],$table["data"]);
}

    /**
     *
     * @return array 返回值
     */
    public function Withdrawing(){
        $mid= input("id");
        $money= input("money");
        $with = new view_group();
        $table = $with->Withdrawing($mid,$money);
        return $this->apiReturn($table["type"],$table["lang"],$table["data"]);
    }
}