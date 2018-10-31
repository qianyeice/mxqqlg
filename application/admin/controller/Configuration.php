<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/5/8
 * Time: 17:29
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Admin_package;
use app\admin\model\Admin_coupon_package;
//use qiniuSdk\qiniuSdk;
//use  think\facade\Request;

class Configuration extends adminController
{
    /**
     * 礼包配置主页
     * 吴杰
     * 2018.5.8
     * @return \think\response\View
     */
    public function index()
    {
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $pack = new admin_package();
//        $coupon = new admin_coupon_package();
        $data = $pack->get_coupon($start,$limit);
        $number = $pack->coupon();
//        $con = $coupon->count_coupon($start,$limit);
//        $num = $coupon->coupon();
        $this->assign("limit",$limit);
        $this->assign("data", $data);
        $this->assign("count", count($number));
        return view();
    }



    /**
     * 礼包配置
     * time:2018.5.9
     * name:吴杰
     * 编辑 渲染页面
     * 传递数据
     */
    public function edit()
    {
        $id = input('id');
        if ($id) {
            $coupon = new Admin_package();
            $data = $coupon->find_coupon($id);
            $cont=explode(",",$data[$id]["pagname"]);
            $this->assign([
                "cont" =>$cont,
                "data" => $data[$id],
                'id' => $id,
            ]);
            return view('configu/index');
        } else {
            return view('configu/index');
        }

    }

    /**
     *礼包配置删除
     */
    public function adelete()
    {
        $id =explode(",",input('id'));
        $coup = new Admin_package();
        return $coup->delet($id);
    }

    public function lete(){
        $name=input("name");
        $id=input("id");
        $coup = new Admin_package();
      return $coup->lete($id,$name);
    }

    /**
     * 礼包配置选择奖品
     * 吴杰
     */
    public function choice(){
        $id=input("id");
        $type=isset($_GET["type"])?$_GET["type"]:2;
        $start = !is_null(input('page')) ? input('page')+1: 1;
        $limit = !is_null(input('limit')) ? input('limit'): 3;
        $coup = new Admin_package();
        $date=$coup->get_sku($start,$limit);
        $total=$coup->count_sku();
        $this->assign("limit",$limit);
        $this->assign('count', $total);
        $this->assign('date', $date);
        $this->assign('id', $id);
//        $con=$coup->selec($id);
//        $this->assign('con',$con);
        $this->assign("type",$type);
        return view('configu/choice');
    }
    /**
     * 新增礼包内容
     * @return bool
     */
    public function share(){
        $id=input("id");
        $bag =explode(",",input('data'));
        $con=explode(",",input('date'));
        $coup = new Admin_package();
        $date=$coup->share($id,$bag,$con);
        return $date;

    }

    public function update(){
        $id=input("id");
        $number=input("name");
        $con=input("con");
        $coup = new Admin_package();
        $date=$coup->upda($id,$number,$con);
        if($date>0){
            return true;
        }
    }

    /**
     * 新增礼包
     * 吴杰
     * @return string
     */
    public function cun(){
        $id=input("id");
        $name=input("name");
        $start=input("start_time");
        $end=input("end_time");
        $frequeny=input("frequeny");
        $coup = new Admin_package();
        if($id){
            $date=$coup->updat($id,$name,$start,$end,$frequeny);
        }else{
            $date=$coup->newupdat($name,$start,$end,$frequeny);
        }

        if($date>0){
            return '?s=admin/Configuration/index';
        }
    }
}