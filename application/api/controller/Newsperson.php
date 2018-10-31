<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/5/28
 * Time: 11:18
 */
namespace app\api\controller;
use app\api\model\GoodsSpu;
use apiController\apiController;

class Newsperson  extends apiController
{
    /**
     * 新人商城入口判断接口编写
     * 吴杰
     * @return array
     */
    public function index(){
        $id=input('id');
        if(!is_null($id)){
            $con=new GoodsSpu();
            $data= $con->nperson($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }

    }
}