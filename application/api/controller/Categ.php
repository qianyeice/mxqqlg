<?php
/**
 *
 * Created by PhpStorm.
 * User: 谢岸霖
 * Date: 2018/3/21
 * Time: 16:23
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Category;

class Categ extends apiController
{
    /**
     *分类
     * 陈健英
     * $id ：
     */
    function index()
    {
        $new = new Category();
        $data=$new->sele();

//        return $data;
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
    }

}