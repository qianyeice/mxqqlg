<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13
 * Time: 18:53
 */
namespace app\admin\controller;
use adminController\adminController;
use qiniuSdk\qiniuSdk;
class Qiniu extends adminController
{
    public function index()
    {
        return view('index');
    }

    public function test(){
        if ($_FILES['file']) {
            $file = $_FILES['file'];//获取上传文件的全部信息
            $name = $file['name'];//获取上传文件的名称
//            $type = $file['type'];//获取上传文件的类型
//            $size = $file['size'];//获取上传文件的大小
            $tmpName = $file['tmp_name'];//获取上传文件的临时存储目录
                $data=new qiniuSdk();
                $aa= $data->q_upload($name,$tmpName);
                return '成功';
        }
    }
}





