<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/16
 * Time: 10:08
 */

namespace app\admin\model;

use think\Model;


class Promotion_commodity_seckill extends Model
{

    /**
     * 数量查询
     * @param $number 查询数据
     * @param $name 定义空数组
     * @return count($name)返回参数
     * name 岳军章
     * time 2018/4/21 14:00
     */
    public function lists_number()
    {
        $number = $this->field('id,Promotion_commodity_id')->select();

        $name = array();
        //去除重复值
        foreach($number as $k=>$v){
            if(!in_array($v['Promotion_commodity_id'], $name)){ // 未使用过
                $name[$k] = $v['Promotion_commodity_id'];
            }
        }
        return count($name);
    }

    /**
     * 数据查询
     * @param $lists
     * @return $array
     * name 岳军章
     * time 2018/4/20 14:00
     */
    public function lists($start,$limit)
    {
        //查询数据
        $lists = $this
            ->field('id,Promotion_commodity_id,name,date,Screenings,Screenings_start_time,Screenings_end_time,spu_price,is_display')
            ->where('panduan',1)
            ->order('id', 'desc')
            ->group('Promotion_commodity_id')
            ->page($start,$limit)
            ->select();

//        $val = [];
//        //获取Promotion_commodity_id长度
//        for ($i = 0; $i < count($lists); $i++) {
//            $val[$i] = $lists[$i]['Promotion_commodity_id'];
//            //去除重复值
//            $qwe = array_unique($val);
//            //查询一条数据
//            $flag=-1;
//            foreach ($qwe as $key=>$vo){
//                $flag++;
//                $data[$flag]=$this
//                    ->field('id,Promotion_commodity_id,name,date,Screenings,Screenings_start_time,Screenings_end_time,spu_price,is_display')
//                    ->order('id', 'desc')
//                    ->where('Promotion_commodity_id',$qwe[$key])
//                    ->find();
//            }
//        }
        $array = $lists;
//        if(count($data)>$limit){
//            for($i=$start;$i<$limit;$i++){
//                $array[$i]=$data[$i];
//            }
//        }else{
//            for($i=$start;$i<count($data);$i++){
//                $array[$i]=$data[$i];
//            }
//        }


        if (!$lists) {
            $array['lang'] = '没有数据';
        }
        return $array;
    }

    public function edit_finds($id)
    {
        $finds = $this->where('Promotion_commodity_id', $id) ->find();
        //$this->query('CALL proc_root();');
        $array = [];
        if ($finds) {
            $array = $finds->toArray();
        } else {
            $array['lang'] = '没有数据';
        }
        return $array;
    }


}