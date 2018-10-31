<?php
namespace app\admin\model;

use think\Model;

class Site_courier extends Model{
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 快递设置 view数据
     */
    public function couall(){
        return $this->find();
    }
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 快递设置 更新
     */
    public function couupdata($id,$array){
        $data=$this->where('id',$id)->update([
            'sendername'=>$array[0],
            'senderphone'=>$array[1],
            'senderaddress'=>$array[2],
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