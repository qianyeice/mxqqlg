<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 16:05
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Skugoods;
/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 商品类型信息
 * Date: 2018/3/29
 * Time: 9:59
 */

/**
 * 吴杰
 * 商品列表--类型 重做
 * 2018.5.22
 * Class Commoditytypetwo
 * @package app\admin\controller
 */
class Commoditytypetwo extends adminController {
   public function init(){
        $id=input('id');
        $beef = new Skugoods();
//        $apple = $beef->sel($id);
        $app = $beef->selet($id);
        $this->assign('vo',$app);
        return view();
    }

    /**
     * 商品列表--类型 保存属性
     * 吴杰
     * 2018.5.22
     */
    public function updat(){
        $id=input('id');
//        if($flag==1 || $app==true){
//            echo "<script>alert('编辑成功！');location.href='?s=admin/Commoditytypetwo/init&id='+$id</script>";
//        }else {
            echo "<script>location.href='?s=admin/Detailsetting/init&id='+$id</script>";
//        }
    }
}