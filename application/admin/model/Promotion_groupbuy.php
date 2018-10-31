<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 10:29
 */

namespace app\admin\model;

use think\Model;

class Promotion_groupbuy extends Model
{
    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 查询团购规则数据库
     * name:龚文凤
     * time：2018/4/8 14：47
     */
    public function TuanGouChaXun($start,$limit)
    {
        //查询所有数据并以数组方式显示
        $jg = $this->page($start,$limit)->select()->toArray();
        //循环
        for ($i = 0; $i < count($jg); $i++) {
            //取出到期时间
            $expires = $jg[$i]['expires'];
            $time = $expires / 60 / 60;
            //把算出来的到期时间覆盖到原来的数组里面
            $jg[$i]['expires'] = $time;
            //取出规则并转换成数组
            $rules = json_decode($jg[$i]['rules']);
            //用原来的结果覆盖以前的规则
            $jg[$i]['rules'] = $rules;
        }
        //数据转换 （把字符串链接成一段文字）
        for ($i = 0; $i < count($jg); $i++) {
            //转换成数组
            $hh = (array)$jg[$i]['rules'];
            //定义一个空下标
            $jg[$i]['miaoshu'] = '';
            for ($s = 0; $s < count($hh); $s++) {
                //求得到的数组的长度
                $count = count($hh);
                //转换成对象
                $hharr = (object)$jg[$i]['rules'];
                if ($count != $s + 1) {
                    // if ($s == 0) {
                    //jg[$i]['miaoshu'] .= ($count - 1) . "人团：";
                    // }
                    $jg[$i]['miaoshu'] .= $s . "人：" . ((100 - $hharr->{$s + 1}) != 100 ? $hharr->{$s + 1} : '0') . "%,";
                } else {
                    $jg[$i]['miaoshu'] .= '满人团长：' . $hharr->leader . "%,";
                }
            }
        }
        return $jg;
    }

    //总条数
    public function cou()
    {
        return $this->count();
    }

    public function TianJia($arr)
    {
        //添加
        if ($arr[5] == 0) {
            return $this->insert(array(
                'title' => $arr[0],
                'max_num' => $arr[1],
                'rules' => $arr[4],
                'expires' => $arr[2] * 60 * 60,
                'explain' => $arr[3]
            ));
            //修改
        } else {
            return $this->where('id', $arr[5])->update(array(
                'title' => $arr[0],
                'max_num' => $arr[1],
                'rules' => $arr[4],
                'expires' => $arr[2] * 60 * 60,
                'explain' => $arr[3]
            ));
        }
    }

    //修改页面一条数据
    public function ymsj($id)
    {
        return $this->where('id', $id)->select()->toArray();
    }
    //删除
    public function shanchu($id){
        return $this->where('id',$id)->delete();
    }
}