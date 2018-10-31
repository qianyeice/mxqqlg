<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 9:45
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Wechat_payment;
use think\Request;


class Paymentadd extends adminController
{
    /**
     * 支付设置
     * @return \think\response\View
     */
    public function index()
    {

        $config = isset($_GET['config']) ? $_GET['config'] : 0;
        if (!$config) {
            //安装
            $pay = new Wechat_payment();
            $all = $pay->upa();
            if ($all['operation'] == $_GET['op']) {
                $_GET['op'] = '1';
            }
            $array = [
                'id' => $_GET['id'],
                'op' => $_GET['op']
            ];
            return view('index')->assign([
                'array' => $array,
                'type' => 0,
            ]);
        } else {
            //配置
            $pay = new Wechat_payment();
            $all = $pay->upa();
            return view('index')->assign([
                'all'=> $all,
                'type' => 1,
                ]);
        }
    }

    /**
     * time:18-4-12 20.50
     * name:邓剑
     * 支付设置  更新
     */
    public function upupdata()
    {
        $array = input('array/a');
        $id = array_pop($array);
        $pay = new Wechat_payment();
        return $pay->chatupdata($id, $array);
    }
}