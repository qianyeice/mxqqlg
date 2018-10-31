<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Api_journal;
use https\curl;
use think\Controller;

class Apijournal extends adminController{
    /**
     * 接口日志
     * time：18-4-11 11:56
     * author:冯云祥
     */
    public function index(){
        $page=input('get.page');
        $length=input('get.length');
        $Api_journal=new Api_journal();
        if($page && $length){
            $journal=$Api_journal->api_journal($page,$length);
        }else{
            $journal=$Api_journal->api_journal();
        }
        $count=$Api_journal->journal_length();
        $this->assign('journal',$journal);
        $this->assign('count',$count);
        return view();
    }

    //搜索
    public function search(){
        $data=input();
        $qian=strtotime($data['integral_ratio']);
        $hou=strtotime($data['integral_ratio2']);
        $rizhi=new Api_journal();
        $shijian=$rizhi->search($qian,$hou);
        echo json_encode($shijian);
    }
}