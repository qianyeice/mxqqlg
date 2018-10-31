<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 14:08
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\CustomerService;

class Customeraddition extends apiController
{
    /**
     * 客服留言添加
     * 程建 2018-3-27 15:20
     * @return array 返回添加成功/失败
     */
    public function addition_message()
    {
        $name = input("post.name");
        $phone = input("post.phone");
        $email = input("post.email");
        $title = input("post.title");
        $text = input("post.text");
        //   实例化CustomerService
       $data=new CustomerService();
        //        引用Customer_into方法
       $val=$data->Customer_into($name,$phone,$email,$title,$text);
        //        调用返回数据
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }
}