<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 16:49
 */
namespace app\admin\controller;

use adminController\adminController;

use app\admin\model\Skugoods;
use qiniuSdk\qiniuSdk;

/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 商品图册
 * Date: 2018/3/29
 * Time: 9:59
 */
class Merchandiseatlas extends adminController {
    function init(){
        $id = input('get.id');

        $beef = new Skugoods();
        $apple = $beef->sel($id);
        $app = $beef->selet($id);
        $this->assign('vo',$apple);
        $this->assign('table',$app);
        return view();
    }

    /**
     * 商品图册图片上传
     * 吴杰
     * 2018.5.22
     */
    function url()
    {
        $logo = $_FILES["file"]["tmp_name"];
        $flag=0;
        if ($logo[0] != "") {
            $filename = md5('Setbrand' . $_FILES['file']['name'][0]) . time();
            $filetmp = $_FILES['file']['tmp_name'][0];
            $qin = new qiniuSdk();
            $data = $qin->q_upload($filename, $filetmp);
            $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
            $beef = new Skugoods();
            $apple = $beef->sele(input("id"), $log);
            if($apple>0){
                $flag=1;
            }
        }
        $array = [];
        for ($i = 1; $i < count($logo); $i++) {
            if ((!empty($logo[$i]))) {
                $filename = md5('Setbrand' . $_FILES['file']['name'][$i]) . time();
                $filetmp = $_FILES['file']['tmp_name'][$i];
                $qin = new qiniuSdk();
                $data = $qin->q_upload($filename, $filetmp);
                $log = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
                $array[$i - 1] = $log;
            } else {
                $array[$i - 1] = " ";
            }
        }
                $beef = new Skugoods();
                $app = $beef->phot(input("id"), $array);
        $id=input("id");
        if($flag==1 || $app==true){
            echo "<script>alert('编辑成功！');location.href='?s=admin/Commoditytypetwo/init&id='+$id</script>";
        }else {
                echo "<script>location.href='?s=admin/Commoditytypetwo/init&id='+$id</script>";
            }
    }

    /**
     * 商品图册删除操作
     * 吴杰
     * 2018.5.22
     */
    public function delet(){
        $beef = new Skugoods();
       return $beef->delet(input("id"));
    }

    public function dele(){
        $beef = new Skugoods();
        return $beef->dele(input("id"),input("idd"));
    }
}