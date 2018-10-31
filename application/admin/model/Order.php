<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/26
 * Time: 15:32
 */

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    /**
     *time:18-4-24 21.43
     * name:邓剑
     * 用户 - 全球分红 - 订单总金额
     */
    public function querys($today)
    {
        $all = $this->select();
        $array = [];
        $cyan = [];
        foreach ($all as $k => $v) {
            if ($v['pay_time'] > $today) {
                $array[$k] = $v;
            }
        }
        foreach ($array as $kk => $vv) {
            $cyan[$kk] = $vv['paid_amount'];
        }
        $sum = array_sum($cyan);
        return $this->my($sum);
    }

    /**
     *time:18-4-24 21.43
     * name:邓剑
     * 用户 - 全球分红 -  日期选择
     */
    public function datechoose($dateof, $dateoff)
    {
        $array = [];
        $all = $this->select();
        for ($i = 0; $i < count($all); $i++) {
            if ($all[$i]['pay_time'] > $dateof && $all[$i]['pay_time'] < $dateoff) {
                $array[$i] = $all[$i]['paid_amount'];
            }
        }
        $sum = array_sum($array);
        return $this->my($sum);
    }

    private function my($sum)
    {
        $num = strpos($sum, '.');
        if ($num) {
            $len = substr($sum, $num);
            if (strlen($len) == 2) {
                $sum = $sum . '0';
            } else {
                $sum = $sum;
            }
        } else {
            $sum = $sum . '.00';
        }
        return $sum;
    }

    /**
     * 指定日期订单统计数据
     * name:张平
     * @param $days 天数
     * @param $end  日期
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function date_statistics($days,$end)
    {
        if($end!=null){
            $day=strtotime($end);
            $data=$this->query('call pro_order_between('.$days.','.$day.')');
        }else{
            $data = $this->query('call pro_order_statistics(' . $days .')');
        }
        $array=array();
        if (count($data) != 0) {
            foreach ($data[0] as $vo) {
                $array[$vo['day']] = $vo;
            }
        }
        return $array;
    }

    /**
     * 获取每日销售订单数据
     * name:张平
     * @return mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function cancel_order()
    {
        $data = $this->query('call pro_order_statistics(0)');
        if (count($data) == 0) {
            $data['cancel'] = -1;
        } else {
            $where['DATE(order_time)'] = ['=', 'DATE(NOW())'];
            $where['hd_type'] = ['=', '1'];
            $count = $this->where($where)->count();
            $data = $data[0][0];
            $data['cancel'] = $count;
        }
        return $data;
    }



}
