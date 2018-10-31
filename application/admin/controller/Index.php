<?php
namespace app\admin\controller;
use qiniuSdk\qiniuSdk;
use think\Controller;
class Index extends Controller{
    public function index()
    {
        $this->redirect(url('/'.'?s='.'admin/Login'));
    }
}