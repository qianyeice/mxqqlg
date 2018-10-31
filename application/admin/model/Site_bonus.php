<?php
namespace app\admin\model;

use think\Model;

class Site_bonus extends Model{
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 分红设置 view数据
     */
    public function bonall(){
        return $this->find();
    }
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 分红设置 更新
     */
    public function bonupdata($id,$array){
        $data=$this->where('id',$id)->update([
            'orbonus'=>$array[0],
            'bonusproportion'=>$array[1],
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