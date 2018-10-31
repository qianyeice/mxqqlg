<?php
namespace app\admin\model;

use think\Model;

class Site_dream extends Model{
    /**
     * time:19-4-11 15.25
     * name:邓剑
     * 站点设置 梦想币设置 - 抓取数据
     */
    public function dreall(){
        return $this->select();
    }
    /**
     * time:19-4-11 15.25
     * name:邓剑
     * 站点设置 梦想币设置 - 更新
     */
    public function dreupdata($id,$array){
        $data=$this->where('id', $id)->update([
            'dream' => $array[0],
            'buyordinary' => $array[1],
            'buybulk' => $array[2],
        ]);
        $cyan=[];
        if ($data){
            $cyan=[
                'type' => '1',
                'explain'=>'更新成功'
            ];
        }else{
            $cyan=[
                'type' => '0',
                'explain'=>'更新失败'
            ];
        }
        return $cyan;
    }
}