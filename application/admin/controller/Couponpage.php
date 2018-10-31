<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/29
 * Time: 13:51
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Coupon_base;
use qiniuSdk\qiniuSdk;
use  think\facade\Request;

class Couponpage extends adminController
{
    /**
     * 优惠券管理主页
     * time：18-3-29 14:16
     * author:陈明福
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 分页 --  优惠券总数
     */
    public function index()
    {
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
//        $limit = Request::has('limit', 'get') ? Request::get('limit') : 5;
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $coupon = new Coupon_base();
        $data = $coupon->get_coupon($start,$limit);
        $zhi = $coupon->count_coupon();
        $this->assign("limit",$limit);
        $this->assign("data", $data);
        $this->assign("count", $zhi);
//        $pagenumber = ceil($zhi / $limit);
//        $this->assign("pagenumber", $pagenumber);
        return view();
    }

    /**
     * time:18-4-19 16.44
     * name:邓剑
     * 文件上传
     * 添加
     */
    public function coupadd()
    {
        $hiddenid = explode(' ', input('hiddenid'));
        $pink = explode(',', input('pink'));
        $white = explode(',', input('white'));
        $black = explode(',', input('black'));
        $file=explode(',',input('file'));
//        dump($file);
//        exit();
        if ($hiddenid[0] == 'undefined') {
            //添加
            if ($_FILES) {
                $filename=md5('coupicon' .$_FILES['file']['name'][0]).time();
                $file_tmp=$_FILES['file']['tmp_name'][0]/a;
                $qin = new qiniuSdk();
                $data = $qin->q_upload($filename,$file_tmp);
                $icon = 'http://p5od7vvyw.bkt.clouddn.com/' . $data["key"];
                $data=input();
                $coup = new Coupon_base();
                return $coup->coupicon($icon, $pink, $white, $black);
            } else {
                $coup = new Coupon_base();
                return $coup->coupadd($pink, $white, $black);
            }
        } else {
            //编辑
            if ($_FILES) {
                $filename = md5('coupicon' . $_FILES['file']['name'][0]) . time();
                $filetmp = $_FILES['file']['tmp_name'][0];
                $qin = new qiniuSdk();
                $data = $qin->q_upload($filename, $filetmp);
                $coup = new Coupon_base();
                $array = 'http://127.0.0.1/api/public/?s=admin/couponpage/edit' . $data["key"];
                return $coup->coupedity($array, $pink, $white, $black, $hiddenid);
            } else {
                $coup = new Coupon_base();
                return $coup->coupeditn($pink, $white, $black, $hiddenid);
            }
        }
    }

    /**
     * time:18-4-19 16.44
     * name:邓剑
     * 编辑 渲染页面
     * 传递数据
     */
    public function edit()
    {
        $id = Request::get('id');
        if ($id){
            $coupon = new Coupon_base();
            $data = $coupon->find_coupon($id);
            $this->assign([
                "data" => $data[0],
                'id' => $id,
            ]);
            return view();
        }else{
            return view()->assign('id', $id);
        }
    }

    /**
     *单选删除
     */
    public function adelete()
    {
        $id = input('id');
        if (isset($id)){
            $coup = new Coupon_base();
            $coup->coupadelete($id);
            $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=couponpage&a=index'));
        }
    }
    /**
     *
     */
    public function alldelete()
    {
//        $id = input('array/a');
//        $coup = new Coupon_base();
//        return $coup->coupalldel($id);
        $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=couponpage&a=index'));
    }
}