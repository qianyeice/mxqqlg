<?php

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Site_basic;
use qiniuSdk\qiniuSdk;

class Basicsetup extends adminController
{
    /**
     * 基本设置
     * @return \think\response\View
     */
    public function index()
    {
        $bas = new Site_basic();
        return view('index')->assign('bas', $bas->basall());
    }

    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 基本设置 更新
     */
    public function siteupdata()
    {
        $basid = explode(' ', input('basid'));
        $defaul = explode(',', input('defaul'));
        if ($_FILES) {
            $filename = md5('malllogo' . $_FILES['file']['name']) . time();
            $filetmp = $_FILES['file']['tmp_name'];
            $qin = new qiniuSdk();
            $data = $qin->q_upload($filename, $filetmp);
            $logo = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
            $bas = new Site_basic();
            return $bas->basupdata($basid[0], $defaul, $logo);
        } else {
            $bas = new Site_basic();
            return $bas->basupdatas($basid[0], $defaul);
        }
    }
}