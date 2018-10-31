<?php
namespace app\api\controller;

use apiController\apiController;

class Withdraw extends apiController
{
    /*
     * 提现发起请求
     * 冯云祥
     * $wtype 提现类型   1：提现至银行卡，0：提现至微信零钱
     * $amount 提现金额
     * $member_id用户id
     */
    public function select(){
        $member_id=input('member_id');
        $wtype=input('wtype');
        $amount=input('amount');
        $Withdraw=new \app\api\model\Withdraw();
        $data=$Withdraw->caxun($member_id,$wtype,$amount);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
}