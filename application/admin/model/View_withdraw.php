<?php

namespace app\admin\model;

use think\Model;

class View_withdraw extends Model
{
    /**
     * time:18-4-24 10.35
     * name:邓剑
     * 待审核
     */
    public function audit($state,$start,$limit)
    {
        $where['w_type']=['=',$state];
        $field=' id, w_wtype,w_amount,w_applytime,w_type,nickname';
        $data= listPage($field,$where,$start,$limit,$this);
        $count=$data['count'];
        unset($data['count']);
        $data=$this->processing($data);
        return array(
            'count'=>$count,
            'data'=>$data
        );
    }

    /**
     * time:18-4-24 10.35
     * name:邓剑
     * 待审核 - 退还余额
     */
    public function auditreturnmodel($id)
    {
        $data = $this
            ->where('w_id', $id)
            ->where('mb_id_default', '1')
            ->where('mb_is_delete', '1')
            ->find();
        return $array = [
            'id' => $data['m_id'],
            'am' => $data['m_money'] + $data['w_amount']
        ];
    }

    /**
     * 数据处理
     */
    private function processing($data)
    {

        $array = [];
        foreach ($data as $k => $v) {
            if ($v['w_wtype'] == '1') {
                $v['w_wtype'] = '提现至银行卡';
            } else {
                $v['w_wtype'] = '提现至微信零钱';
            }
            $v['five']=$v['w_type'];
            switch ($v['w_type']) {
                case 0:
                    $v['w_type'] = '待审核';
                    break;
                case 1:
                    $v['w_type'] = '待发放';
                    break;
                case 2:
                    $v['w_type'] = '已发放';
                    break;
                case 3:
                    $v['w_type'] = '发放失败';
                    break;
                case 4:
                    $v['w_type'] = '未通过';
                    break;
                default:
                    break;
            }
            $num = strpos($v['w_amount'], '.');
            if ($num) {
                $len = substr($v['w_amount'], 2);
                if (strlen($len) == 2) {
                    $v['w_amount'] = $v['w_amount'] . '0';
                } else {
                    $v['w_amount'] = $v['w_amount'];
                }
            } else {
                $v['w_amount'] = $v['w_amount'] . '.00';
            }
            $array[$k] = $v;
        }
        return $array;
    }
}