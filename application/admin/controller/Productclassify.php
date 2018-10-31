<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 15:49
 */

namespace app\admin\controller;

use adminController\adminController;

class Productclassify extends adminController
{
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 商品分类设置
     * Date: 2018/3/29
     * Time: 9:59
     */
    public function setcomclass()
    {
        return view('setcomclass');
    }
}