<?php
namespace app\admin\model;

use think\Model;

class Site_returngoods extends Model{
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 退货设置 view数据
     */
    public function retall(){
        return $this->find();
    }
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 退货设置 更新
     */
    public function retupdata($id,$array){
        $data=$this->where('id',$id)->update([
            'returntime'=>$array[0],
            'receiptaddress'=>$array[1],
            'receiptname'=>$array[2],
            'phone'=>$array[3],
            'zipcode'=>$array[4],
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