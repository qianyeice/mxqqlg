<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 15:11
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Barnd;

class Brand extends adminController {
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 品牌列表
     * Date: 2018/3/29
     * Time: 15:59
     */
    public function index(){

//        $s=null;
//        $start= !is_null($s) ? $s+1 : 1;
//        var_dump($start);



//        exit;

        $start = !is_null(input('page')) ? input('page')+1 : 1;



        $limit = !is_null(input('limit')) ? input('limit') :20;



        $data = new Barnd();



        $tab=$data->read($start,$limit);




        $table=$data->allread();



        $this->assign("limit",$limit);



        $this->assign("count",count($table));



        $this->assign('data',$tab);



        return view('index');



    }

    public function cut(){
        $id = input('id');

        $datas=new Barnd();
        $data=$datas->deleup($id);

        return $data["lang"];
    }

    /**
     * 删除所选中的所有商品品牌
     * 吴杰
     * 2018.5.2
     */
    public function cutall(){
        $id =explode(",",input('idd'));
        $data = new Barnd();
        $con = $data->deleall($id);
        if($con==0){
            return false;
        }else{
            return true;
        }
    }
}