<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Spli_tratio;

class Splitratio extends adminController{
    /**
     * 编辑分成比例
     * time：18-3-29 10:16
     * author:李磊
     * @return \think\response\View
     */
    public function index(){
        $sql=new Spli_tratio;
        $data=$sql->change();
        $this->assign('data',$data);
        $this->assign('yess',$data[0]["yess"]);
        return view('Split_ratio/index');
    }

    /**
     * 分成比例修改
     * 吴杰
     * 2018.4.28
     */
    public function bili(){
        $founder=input("founder");
        $ini=input("ini");
        $parn=input("parn");
        $staff=input("staff");
        $sql=new Spli_tratio;
        $data=$sql->upda($founder,$ini,$parn,$staff);
        return true;
    }

    /**
     * 关闭分成功能
     */
    public function close(){
        $sql=new Spli_tratio;
        $data=$sql->close();

            return true;

    }
}