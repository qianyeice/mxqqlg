<?php

namespace app\admin\model;

use think\Model;

class Site_integralset extends Model
{
    /**
     * time:19-4-11 15.25
     * name:邓剑
     * 站点设置 积分设置 - 抓取数据
     */
    public function intall(){
        return $this->find();
    }
    /**
     * time:19-4-11 15.25
     * name:邓剑
     * 站点设置 积分设置 - 更新
     */
    public function intupdata($id,$array)
    {
       $data=$this->where('id', $id)->update([
           'integralgain' => $array[0],
           'integraldate' => $array[1],
           'integralmultiples' => $array[2],
       ]);
        $cyan = [];
        if ($data) {
            $cyan=[
                'type'=>'1',
                'explain'=>'更新成功'
            ];
        }else{
            $cyan=[
                'type'=>'0',
                'explain'=>'更新失败'
            ];
        }
        return $cyan;
    }
}