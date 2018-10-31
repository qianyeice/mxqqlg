<?php

namespace app\admin\controller;

use adminController\adminController;
use think\Db;
use app\admin\model\Promotion_groupbuy;

class GroupPurchaseEditor extends adminController
{
    /**
     *团购编辑页面
     * @return \think\response\View
     * 丁龙
     * 18.3.29
     * 13.48
     */
    public function index()
    {
        $id = input('get.kid') ? input('get.kid') : 0;
        //编辑页面
        if ($id != 0) {
            $p = new Promotion_groupbuy();
            $fh = $p->ymsj($id);
            $this->assign('sql', $fh[0]);
            $this->assign('pd', 1);
            //添加
        } else {
            $this->assign('pd', 0);
        }
        return view();
    }

    /**
     * 团购数据上传
     * @return array 返回数据
     * 丁龙
     */
    public function TuanGouTianJia()
    {
        if ($this->request->isAjax()) {
            $inp = input('post.val/a');
            $p = new Promotion_groupbuy();
            $fh = $p->TianJia($inp);
            if ($fh == 1) {
                return array(
                    'type' => 1,
                    'data' => '处理成功'
                );
            }else{
                return array(
                    'type' => 0,
                    'data' => '处理失败'
                );
            }
        } else {
            return array(
                'type' => 0,
                'data' => '非法访问'
            );
        }
    }
}