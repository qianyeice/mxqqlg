<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Config;;
use app\admin\model;
/**
 * ������
 * ��ҳ֪ͨ
 */
class Tddsin extends adminController{
//֪ͨҳ��
    public function index(){
        return view();
    }

//��������֪ͨ����
    public function tongzhi(){
//      var_dump($_POST);
//      die();
        $val= input('post.val');
        $config = new Config();
        $aa=$config->xiugai($val);
      if($aa==1){
          return true;    //����״̬
      }else{
          return false;   //�ر�״̬
      }

    }

//�ر�֪ͨ��״̬
    public function kaiguan(){
//        var_dump($_POST);
//        die();
        $val= input('post.kg');
        $config = new Config();
        $config->kaiguan($val);
        return true;
    }

}