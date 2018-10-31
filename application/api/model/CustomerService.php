<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 14:02
 */
namespace app\api\model;
use think\Model;
class CustomerService extends Model{
    /**
     * 客服留言添加
     * 程建 2018-3-27 15:19
     * @param $name姓名
     * @param $phone电话
     * @param $email电子邮箱
     * @param $title标题
     * @param $text内容
     * @return array 返回添加成功/失败
     */
    function Customer_into($name,$phone,$email,$title,$text){
        $array=array();
//        判断电子邮箱正则
        if (preg_match(config('email'),$email)) {
//            判断电话正则
            if(preg_match(config('phone'),$phone)){
//                组装数组加入数据库
                $data = ['name' => $name, 'phone' =>$phone,'email'=>$email,'subject'=>$title,'message'=>$text];
                $fan=$this->insert($data);
//                判断是否存储成功
                  if($fan){
                      $array["type"]=1;
                      $array["lang"]='success';
                  }else{
                      $array["type"]=0;
                      $array["lang"]='Add_success';
                  }
            }else{
                $array["type"]=0;
                $array["lang"]='regular_phone';
            }
        }else{
            $array["type"]=0;
            $array["lang"]='regular_email';
        }
        $array["data"]='';
        return $array;
    }
}