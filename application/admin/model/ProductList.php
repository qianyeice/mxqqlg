<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 17:08
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class ProductList extends Model
{
    /**
     * 商品列表
     * Time: 2018\4\8  11:20
     * name：陈昌海
     */
    function product_lists($start, $limit)
    {
        $data = $this
            ->where('spustatus', '>', '-1')
            ->page($start, $limit)
            ->order('id', 'desc')
            ->group('id')
            ->page($start, $limit)
            ->select();
        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    function product_li()
    {
        $data = $this
            ->where('spustatus', '>', '-1')
            ->group('id')
            ->select();
        return count($data);
    }

    function product($lable = 1, $fenlei, $barnd, $keyword, $start, $limit)
    {
        if($start>0){
            $start=$start*$limit+1;
        }
        if ($lable == null || $lable == 1) {

            $lable = ' spustatus in ("0","1") ';
        } elseif ($lable == 2) {

            $lable = ' spustatus in ("0") ';
        } elseif ($lable == 3) {
            $lable = ' notice > skunumber';
        }
        if (!empty($fenlei)) {
            $fenlei = ' and catid=' . $fenlei;
        } if (!empty($barnd)) {
            $barnd = ' and brand_id=' . $barnd;
        } if (!empty($keyword)) {
            $keyword = ' and (spuname like "%' . $keyword . '%" or spusn like "%' . $keyword . '%")';
        }


        $data['data'] = $this->query('select * from product_list where ' . $lable . $fenlei . $barnd . $keyword . ' GROUP BY id ORDER BY id DESC limit ' . $start . ',' . $limit);
        $data['count'] = $this->query('select * from product_list where ' . $lable . $fenlei . $barnd . $keyword . ' GROUP BY id ORDER BY id DESC ');
        return $data;
    }
//    判断条件


    /*
     * 品牌
     */
    function brand()
    {
        $beef = Db::table('barnd')->select();
        return $beef;
    }

    function off($id)
    {
        $data = Db::table('goods_spu')->where('id', $id)->find();

        return $data;
    }

    function shelfoff()
    {
        $data = $this
            //->field('id,spuname,spusn,shop_price,market_price,spustatus,sputype,barndname,catname,skunumber,skusort,spucontent,thumb')
            ->where('spustatus', '0')
            ->select();

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    //回收站
    function prorecycle()
    {
        $data = $this
            ->where('spustatus', '-1')
            ->select();

        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    //库存警告
    function proinventory($ints)
    {
        $data = $this
//            ->where('skunumber','<','notice')
            ->where('spustatus', 'neq', '-1')
            ->select();
        $array = [];
        $flag = 0;
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['skunumber'] < $data[$i]['notice']) {
                $array[$flag] = $data[$i];
                $flag++;
            }
        }
        if (count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 删除
     * 吴杰
     * @param $id
     */
    public function delet($id)
    {
        $data = Db::name('goods_spu')
            ->where('id', 'in', $id)
            ->update(['status' => -1]);
        return $data;
    }

    /**
     * 回收站删除
     * 吴杰
     * @param $id
     */
    public function delett($id)
    {
        $data = Db::name('goods_spu')
            ->where('id', 'in', $id)
            ->delete();
        return $data;
    }

    /**
     * 恢复操作
     * 吴杰
     * @param $id
     */
    public function live($id)
    {
        $data = Db::name('goods_spu')
            ->where('id', $id)
            ->update(['status' => 0]);
        return $data;
    }
}