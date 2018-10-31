<?php
namespace app\admin\model;

use think\Model;

class Wechat_payment extends Model{
    /**
     * time:18-4-12 20.50
     * name:邓剑
     * 支付方式  view 数据
     */
    public function upa(){
        return $this->find();
    }
    /**
     * time:18-4-12 20.50
     * name:邓剑
     * 支付设置  更新
     */
    public function chatupdata($id, $array)
    {
        $data = $this->where('id', $id)->update([
            'appID' => $array[0],
            'mch_id' => $array[1],
            'key' => $array[2],
            'Appsecret' => $array[3],
            'operation' => $array[4],
        ]);
        $pink = [];
        if ($data) {
            $pink = [
                'type' => '1',
                'explain' => '更新成功'
            ];
        } else {
            $pink = [
                'type' => '0',
                'explain' => '更新失败'
            ];
        }
        return $pink;
    }
    /**
     * time:18-4-12 20.50
     * name:邓剑
     * 支付方式  卸载
     */
    public function chatunall($unid,$string)
    {
        $data = $this->where('id', $unid)->update([
            'appID' => '',
            'mch_id' => '',
            'key' => '',
            'Appsecret' => '',
            'operation' => $string,
        ]);

        $pink = [];
        if ($data) {
            $pink = [
                'type' => '1',
                'explain' => '卸载成功'
            ];
        } else {
            $pink = [
                'type' => '0',
                'explain' => '卸载失败'
            ];
        }
        return $pink;
    }
}