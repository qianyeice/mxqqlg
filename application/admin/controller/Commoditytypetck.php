<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24
 * Time: 16:43
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Typeson;

class Commoditytypetck extends adminController
{
    public function index()
    {

        return view();
    }
    
    public function set_ajax()
    {
        $val = input("post.value");

        $data = new Typeson();
        $apple = $data->addval($val);
        $this ->assign('ao',$apple);
    }
}