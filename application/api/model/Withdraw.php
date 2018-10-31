<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 17:41
 */

namespace app\api\model;


use think\Model;
use Think\Db;

class Withdraw extends Model
{
    /*
     * 提现发起请求
     * 冯云祥
     * $wtype 提现类型   1：提现至银行卡，0：提现至微信零钱
     * $amount 提现金额
     * $member_id用户id
     */
    public function caxun($member_id,$wtype,$amount){
        if($member_id!='' && $wtype!='' && $amount!=''){
            if($wtype==1){

            }elseif ($wtype==0){
                $data=[
                    'mid'=>$member_id,
                    'wtype'=>$wtype,
                    'amount'=>$amount,
                    'applytime'=>date('Y-m-d H:i:s',time()),
                    'type'=>0,
                    'ordernum'=>date('YmdHis',time()).$member_id,
                ];
                $data=$this->insert($data);
                if($data){
                    $money=Db::table('member')->field('money')->where("id",$member_id)->select();
                    $yuan=$money[0]['money']-$amount;
                    Db::table('member')->where("id",$member_id)->update(['money'=>$yuan]);
                }
                $array["type"]=1;
                $array["lang"]=lang('success');
                $array['data']=$data;
            }else{
                $array["type"]=0;
                $array["lang"]=lang('meiyopu');
                $array['data']='';
            }
        }else{
            $array["type"]=0;
            $array["lang"]=lang('meiyopu');
            $array['data']='';
        }
        return $array;
    }
        /**
         * us:付建军
         *
         * @param $id
         * @return array
         */

    function draw($id)
    {
        $with = $this ->where('mid',$id)->select();
        $array=array();
        // 判定是否有数据
        if(count($with)>0){
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$with;
        return $array;
    }

}

