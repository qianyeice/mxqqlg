<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 13:44
 */
namespace adminController;
use app\admin\model\Admin_memu;
use think\Controller;
use think\Db;
use think\facade\Session;
use app\admin\model\Admin_user;
class adminController extends Controller{
     /**
      * 判断是否登录或登录过期
      * 2018-04-2 14:05:37
      * 冯云祥
      */
     public $menu;
     public function _initialize(){
          if(Session::has('id')){
               $id=Session::get('id');

               $date=new Admin_memu();
               $con=$date->mydemo($id,0);
               $idd=input('id');
               $data=array();
               if($idd!=null && $idd<10){
                    foreach($con as $v){
                         if($v['id']==$idd){
                              $left=$date->leftdemo($idd);
                              $data['top']=$con;
                              $data['left']=$left;
                              $this->menu=$data;
                         }
                    }
               }
               if($idd==null){
                    $data=$this->incd($id);
                    $this->menu=$data;
               }

//               $auth=new Admin_memu();
//               $data=$auth->auth($id);
//          if($data){
//               $this->menu= $this->incd($id);
//          }else{
//               $this->error('没有权限');
//          }
          }else{
               $this->redirect('/'.'?s='.'admin/Login');
          }
     }

     /**
      * 分权处理
      * 吴杰
      * 2018.5.11
      * @param $id
      * @return array
      */
     public function incd($id){

          $date=new Admin_memu();
          $con=$date->mydemo($id,0);
          $leftfId=!is_null(input('id'))?input('id'):$con[0]['id'];
          $left=$date->leftdemo($leftfId);
          $data=array(
              'top'=>$con,
              'left'=>$left,
          );
          return $data;
     }
}