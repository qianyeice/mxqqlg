<?php
/**
 *
 * 修改个人资料
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/10
 * Time: 15:14
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\Modify_datum;
class modify extends apiController{
    /**
     * id：用户ID
     * username：用户昵称
     * mobile：用户手机
     * avatar：用户头像
     *
     */
    function datum(){

        $id=input('post.id');

        $username=input('post.username');

        $mobile=input('post.mobile');

        $avatar=$_FILES["avatar"]["tmp_name"];

        $data=new Modify_datum();

        return $data->modifydatum($id,$username,$mobile,$avatar);
    }
}