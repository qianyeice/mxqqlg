<?php

namespace app\admin\model;

use think\Model;

class Group_purchase_management extends Model
{
    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * name：龚文凤
     * Date: 2018/4/10
     * Time: 9:39
     */
    public function chaxun($pd,$start,$limit)
    {
        //查询视图并以数组形式显示，查团长
        $tuangou = $this->page($start,$limit)->where('mgb_leader','1')->select()->toArray();

//        var_dump($shuzu);
//        echo '</pre>';

        $shuzu = array();
        //使用foreach循环分别把需要的‘mgb_groupbuy’（团id）取出来
        foreach ($tuangou as $k => $val) {
            $shuzu[$val['mgb_groupbuy']][] = $val;
        }
//        echo '<pre>';

//        $tuangour = $this->where('mgb_groupbuy','')->select()->toArray();


        //分别把第二个数组的下标循环取出来
        foreach ($shuzu as $k => $v) {
            for ($i = 0; $i < count($v); $i++) {
                //循环取出日期并转换成时间戳
                $zhjg[] = strtotime($shuzu[$k][$i]['gbuy_endtime']);
                //判断团购状态是否结束 1：进行中 0：结束
                if ($zhjg[count($zhjg) - 1] > time()) {
                    $shuzu[$k][$i]['zhuangtai'] = 1;
                } else {
                    $shuzu[$k][$i]['zhuangtai'] = 0;
                }
            }
        }
        switch ($pd) {
            case 0:
                break;
            //进行中
            case 1:
                foreach ($shuzu as $k => $v) {
                    if ($shuzu[$k][0]['zhuangtai'] == 0) {
                        unset($shuzu[$k]);
                    }
                }
                break;
            //已结束
            case 2:
                foreach ($shuzu as $k => $v) {
                    if ($shuzu[$k][0]['zhuangtai'] == 1) {
                        unset($shuzu[$k]);
                    }
                }

                break;
        }

//        $sc=$this->page($start,$limit)->select()->toArray();

//        exit;
        return $shuzu;
    }

    /**
     * @param $id 点击结束的标记
     * @return $this
     * name：龚文凤
     * time：2018/4/12 16:17
     */
    public function XiuGaiShiJian($id){
        $time=date('Y-m-d h:i:s',time());
        //修改视图的结束时间
        return $this->where('mgb_groupbuy',$id)->update(array('gbuy_endtime'=>$time));
    }


    public function xianshi($pd)
{
//        //查询所有数据并以数组方式显示
//        $jg = $this->group('mgb_groupbuy')->where('mgb_leader','1')->select()->toArray();
    $tuangou = $this->where('mgb_leader','1')->select()->toArray();



    $shuzu = array();
    //使用foreach循环分别把需要的‘mgb_groupbuy’取出来
    foreach ($tuangou as $k => $val) {

        $shuzu[$val['mgb_groupbuy']][]=$val;


    }

    //分别把第二个数组的下标循环取出来
    foreach ($shuzu as $k => $v) {
        for ($i = 0; $i < count($v); $i++) {
            //循环取出日期并转换成时间戳
            $zhjg[] = strtotime($shuzu[$k][$i]['gbuy_endtime']);
            //判断团购状态是否结束 1：进行中 0：结束
            if ($zhjg[count($zhjg) - 1] > time()) {
                $shuzu[$k][$i]['zhuangtai'] = 1;
            } else {
                $shuzu[$k][$i]['zhuangtai'] = 0;
            }
        }
    }
    switch ($pd) {
        case 0:
            break;
        //进行中
        case 1:
            foreach ($shuzu as $k => $v) {
                if ($shuzu[$k][0]['zhuangtai'] == 0) {
                    unset($shuzu[$k]);
                }
            }
            break;
        //已结束
        case 2:
            foreach ($shuzu as $k => $v) {
                if ($shuzu[$k][0]['zhuangtai'] == 1) {
                    unset($shuzu[$k]);
                }
            }

            break;
    }

//        $sc=$this->page($start,$limit)->select()->toArray();

//        exit;
    return $shuzu;

//        echo '<pre>';
//        var_dump($jg);
//        echo '</pre>';
//        exit();
    //循环


}

    public function tuan($pd)
    {
//        //查询所有数据并以数组方式显示
//        $jg = $this->group('mgb_groupbuy')->where('mgb_leader','1')->select()->toArray();
        $tuangou = $this->select()->toArray();



        $shuzu = array();
        //使用foreach循环分别把需要的‘mgb_groupbuy’取出来
        foreach ($tuangou as $k => $val) {

            $shuzu[$val['mgb_groupbuy']][]=$val;


        }
        //分别把第二个数组的下标循环取出来
        foreach ($shuzu as $k => $v) {
            for ($i = 0; $i < count($v); $i++) {
                //循环取出日期并转换成时间戳
                $zhjg[] = strtotime($shuzu[$k][$i]['gbuy_endtime']);
                //判断团购状态是否结束 1：进行中 0：结束
                if ($zhjg[count($zhjg) - 1] > time()) {
                    $shuzu[$k][$i]['zhuangtai'] = 1;
                } else {
                    $shuzu[$k][$i]['zhuangtai'] = 0;
                }
            }
        }
        switch ($pd) {
            case 0:
                break;
            //进行中
            case 1:
                foreach ($shuzu as $k => $v) {
                    if ($shuzu[$k][0]['zhuangtai'] == 0) {
                        unset($shuzu[$k]);
                    }
                }
                break;
            //已结束
            case 2:
                foreach ($shuzu as $k => $v) {
                    if ($shuzu[$k][0]['zhuangtai'] == 1) {
                        unset($shuzu[$k]);
                    }
                }

                break;
        }

        return $shuzu;



    }




}