<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 15:12
 */
namespace  app\admin\controller;

use adminController\adminController;
use app\admin\model\Type;
use app\admin\model\Spec;

/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 商品类型
 * Date: 2018/3/29
 * Time: 9:59
 */
class Commoditytype extends adminController {

    public function init(){
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $data=new Type();
        $count= $data->ready();
        $tab = $data->read($start,$limit);
        $this->assign("limit",$limit);
        $this->assign("count",count($count));
        $this->assign('record',$tab);
        $this->assign('record_length',count($tab));

        return view();
    }

    /**
     * @return array
     * User: 李天
     * 商品类型启用关闭
     * Date: 2018/5/4
     * Time: 15:01
     */

    public function Post_open_close()
    {

        $table = new Type();
        $data = $table->close(input('id'), input('close'));
        $data = array(
            'type' => input('close'),
            'id' => input('id'),
            'data' => $data
        );
        return $data;
    }

    public function Post_close(){
        $id =explode(",",input('idd'));
        $table = new Type();
        $data = $table->delet($id);
        if($data!=0){
            return true;
        }else{
            return false;
        }

    }
    public function upsave()
    {
        $bat = new Spec();
        $banana = $bat->selects();
        $this->assign('ban',$banana);

        $id = input('get.id');
        $set = new Type();
        $beef = $set->sel($id);
        $this->assign("arr",explode(",",$beef["specid"]));
        $this->assign('vo',$beef);

//        return view('index');
        return view();
    }


}