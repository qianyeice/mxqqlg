<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 10:05
 */

namespace app\admin\controller;

use adminController\adminController;
use think\Db;
use qiniuSdk\qiniuSdk;

/**
 * Class SiteHomePage
 * @package app\admin\controller 渲染站点首页
 * name:龚文凤
 * time:2018.3.29 09：25
 */
class SiteHomePage extends adminController
{
    /**
     * 站点信息
     * @return \think\response\View
     * 丁龙
     */
    public function index()
    {
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $select = db('adver')->page($start,$limit)->select();
        $count = db('adver')->count();
        $this->assign('count', $count);
        $this->assign('limit', $limit);
        return view('index')->assign('slide', $select);
    }

    /**
     * 添加页面
     * time:18-4-6 15.31
     * name:丁龙
     */
    public function slide()
    {
        $page = input('get.page') ? input('get.page') : 0;
        $this->assign('id', $page);
        if ($page) {
            $select = db('adver')->where('id', $page)->select();
            $this->assign('pd', 0);
            return view('slide')->assign('select', $select[0]);
        } else {
            $this->assign('pd', 1);
            return view('slide');
        }
    }

    /**
     * 接受上传幻灯片返回url
     * 丁龙
     */
    public function files()
    {
        $filename = md5('malllogo' . $_FILES['file']['name'][0]) . time();
        $filetmp = $_FILES['file']['tmp_name'][0];
        $qin = new qiniuSdk();
        $data = $qin->q_upload($filename, $filetmp);
        echo 'http://p5od7vvyw.bkt.clouddn.com/' . $data["key"];
    }

    /**
     * 添加功能
     * @return array 返回判断数组
     * 丁龙
     */
    public function all()
    {
        $array =  input('array/a');
        $pd = input('ispd');
        $id = input('id');
        $all = [
            'img_url' => trim($array[1]),
            'name' => trim($array[0]),
            'url' => trim($array[2])
        ];
        if ($pd == 1) {
            //添加
            $data = Db::name('adver')->insert($all);
            $number = [];
            if ($data == 1) {
                $number = [
                    'type' => '1',
                    'explain' => '完成',
                ];
               // cache("carousel",NULL);
            } else {
                $number = [
                    'type' => '0',
                    'explain' => '未完成',
                ];

            }
            return $number;

            //修改
        } else {
            $data = Db::name('adver')->where('id', $id)
                ->update($all);
            if ($data == 1) {
                $number = [
                    'type' => '1',
                    'explain' => '完成',
                ];
              //  cache("carousel",NULL);
            } else {
                $number = [
                    'type' => '0',
                    'explain' => '未完成',
                ];

            }
            return $number;
        }


    }

    /**
     * 批量删除
     * @return array
     */
    public function alldel()
    {
        $array = input('array/a');
        $data = Db::table('adver')->where('id', 'elt', $array[count($array) - 1])->delete();
        $number = [];
        if ($data) {
            $number = [
                'type' => '1',
                'explain' => '成功删除',
            ];
          //  cache("carousel",NULL);
        } else {
            $number = [
                'type' => '0',
                'explain' => '删除失败',
            ];
        }
        return $number;

    }

    /**
     * 幻灯片单删功能
     * @return mixed返回删除条数
     * 丁龙
     */
    public function del()
    {
        $id = input('id');
        $data = Db::table('adver')->where('id', $id)->delete();
       // cache("carousel",NULL);
        return $data;
    }
}