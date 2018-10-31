<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/24
 * Time: 10:44
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\DreamRule;

class Memberdreamrule extends apiController
{
    /**
     * 会员中心梦想币使用规则
     * 程建 2018-3-24 10:58
     * @return array 返回的规则信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function dream_use_rule()
    {
        //   实例化DreamRule
        $data = new DreamRule();
        //        引用dreamRule_explain方法
        $data = $data->dreamRule_explain();
        //        调用返回数据
        $this->apiJournal($data["type"], $data["lang"], $data["data"]);//日志
        return $this->apiReturn($data["type"], $data["lang"], $data["data"]);//返回格式
    }
}