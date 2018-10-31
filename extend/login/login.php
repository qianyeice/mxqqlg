<?php
namespace login;
use think\Controller;
use think\facade\Session;
/**
 * 吴正勇
 *  _initialize登录验证
 * 判断用户是否登录
 */

class login extends Controller{
    function _initialize()
    {
        $id=Session::has('id');
        if ($id == false) {
            $this->success('请先登录后操作', url('/?'.'s='.'admin/login'));
        }
    }
}
