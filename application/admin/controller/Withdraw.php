<?php

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\View_withdraw;
use https\curl;
use think\facade\Session;

class Withdraw extends adminController
{
    //提现管理 列表
    public function index()
    {
        $state = !is_null(input('state')) ? strstr(input('state'),'.',true) : 0;
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $wit = new View_withdraw();
        $audit= $wit->audit($state,$start,$limit);
        $this->assign("limit",$limit);
        $this->assign("audit",$audit['data']);
        $this->assign("count",$audit['count']);
        $this->assign("state",$state);
        return view();
    }

    public function edit()
    {

        $wit = new \app\admin\model\Withdraw();
        $money=input('post.money');

        if(!empty($money)){
            $id=Session::get('id');
            $ls=$wit->user_ff($id);
            if(md5($money)==$ls[0]['password']){
                if(input('type')==2 || input('type')==4){
                    $order=date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
                    $data=$wit->withdraw_type(input('id'),$order);
//            $pay = new \weChatPay\Withdraw();
                    if($data['w_wtype']==1){
//             $data= $pay->bank($data);
                        if ($data['type']==1) {
                            $data= $wit->withdrawUp(input('id'),$data['data']);
                        }else{
                            $data= $wit->edit(3,input('id'));
                        }
                    }else{
//                $pay->change();
                        $dd=json_decode($data,true);
                        $member_id=$wit->withdraw_id($dd['id']);
                        $a=new curl();
                        $url='http://api.mxqqlg.com/?s=api/Appwxpay/tixian';
                        $zq=[
                            'id'=>2958,
                            'money'=>$dd['w_amount']*100,
                        ];
                        $yes=$a->curl_post_https($url,$zq);
                        $data= $wit->edit(2,input('id'));
                    }
                }else{
                    $data=$wit->edit(input('type'),input('id'));
                }
                return $data;
            }else{
               return 1;
            }
        }else{
            return 0;
        }







    }



}