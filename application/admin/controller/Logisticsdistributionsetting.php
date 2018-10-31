<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\8 0008
 * Time: 16:21
 */
namespace app\admin\controller;
use adminController\adminController;

use Distribution_data_processing\Distribution_data_processing;
use qiniuSdk\qiniuSdk;
use app\admin\model\Logistics_distribution;
use think\facade\Cookie;

;
class Logisticsdistributionsetting extends adminController {
    /**
     * @return \think\response\View
     * $id:  当前选中 id
     */
    public function index(){
        $id=input('id');
        if($id){
            $data=new Logistics_distribution();
            $array=$data->inquiry($id);
            Cookie::set('id',$id,3600);
        }else{
            Cookie::set('id','notid',3600);
            $array['name']='';
            $array['identif']='';
            $array['logo']='';
            $array['sort']=100;
        }
        $this->assign('id',$id);
        $this->assign('name',$array['name']);
        $this->assign('identif',$array['identif']);
        $this->assign('logo',$array['logo']);
        $this->assign('sort',$array['sort']);
        return view();
    }
    /**
     * User: 白锦国
     * 物流配送设置
     * Date: 2018/4/10
     * Time: 14:50
     * $enabled是否开启该物流 1开启 0关闭
     * $name 物流名称
     * $identif 物流标识
     * $logo 上传成功后logo文件名（路径在根目录/uploads/ 目录下）
     * $sort排序
     */
    public function upload(){

        $enabled=  input('enabled');
        $name= input('names');
        $identif=input('identif');
        $sort=input('sort');
        $data=new Distribution_data_processing();
        $shtings="http://p5od7vvyw.bkt.clouddn.com/";
        if($logo=$shtings){
            if($_FILES['image']['name']!="") {
                $a = new qiniuSdk();
                $names = md5($_FILES['image']['name'] . time());
                $yes = $a->q_upload($names, $_FILES['image']['tmp_name']);
                $logo = 'http://p5od7vvyw.bkt.clouddn.com/' . $yes['key'];
                $array=0;
            }else{
                $adds=Cookie::get('id');
                $array=$data->update($enabled,$name,$identif,$sort,$adds);
            }
        }
        if(Cookie::get('id')!='notid'){

           if($array["id"]==1){
             echo $array["type"];
           }else{

               $adds=Cookie::get('id');
               $array=$data->data($enabled,$name,$identif,$logo,$sort,$adds);
               echo $array;
           }

        }elseif (input('images')!=''){

                $adds=Cookie::get('id');
                $logo=input('images');
                $array=$data->data($enabled,$name,$identif,$logo,$sort,$adds);
                echo $array;
        } else{

            $a = new qiniuSdk();
            $names=md5($_FILES['image']['name'].time());
            $yes=$a->q_upload($names,$_FILES['image']['tmp_name']);

            $logo=$names;
            if($yes){
                $adds='1';
                $array=$data->data($enabled,$name,$identif,$logo,$sort,$adds);
                echo $array;
            }else{

            };
        }
    }
}