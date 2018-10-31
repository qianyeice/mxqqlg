<?php

namespace app\api\model;

use think\Model;

class Delivery_template extends Model
{
    /**
     * time:18-3-24 16.15
     * name:邓剑
     * @param $name 快递名称
     * @param $logisticsn   物流运单号
     * @param $username 收件人名称
     * @param $zipcode  邮编
     * @param $phone    联系电话
     * @param $address  邮寄地址
     * @param $reason   特别说明
     * @return false|int 返回的数据
     */
    function courierRefund($name, $logisticsn, $username, $zipcode, $phone, $address, $reason)
    {
        $data = $this->save([
            'name' => $name,
            'logisticsn' => $logisticsn,
            'username' => $username,
            'zipcode' => $zipcode,
            'phone' => $phone,
            'address' => $address,
            'reason' => $reason,
        ]);
        return $data;
    }

    function refundselect(){
        $data=$this->select();
        return $data;
    }
}