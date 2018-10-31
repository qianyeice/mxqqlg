<?php
namespace app\admin\model;

use think\Model;

class Site_logisticscost extends Model{
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 物流费用设置 view数据
     */
    public function logall(){
        return $this->find();
    }
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 物流费用设置 更新
     */
    public function logupdata($id,$array){
        $data=$this->where('id',$id)->update([
            'specialfees'=>$array[0],
            'killfee'=>$array[1],
        ]);
        $cyan=[];
        if ($data){
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