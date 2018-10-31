<?php
namespace app\admin\model;

use think\Model;

class Site_shopping extends Model{
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 购物设置 view数据
     */
    public function shoall(){
        return $this->find();
    }
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 购物设置 更新
     */
    public function shoupdata($id,$cyan){
        $data=$this->where('id',$id)->update([
            'paymenttype'=>$cyan[0],
            'shoppingcart'=>$cyan[1],
            'kuqaset'=>$cyan[2],
            'orbuy'=>$cyan[3],
            'orsum'=>$cyan[4],
            'orinvoice'=>$cyan[5],
            'taxinvoice'=>$cyan[6],
            'invoicecontent'=>$cyan[7],
        ]);
        $pink=[];
        if ($data){
            $pink=[
                'type'=>'1',
                'explain'=>'更新成功'
            ];
        }else{
            $pink=[
                'type'=>'0',
                'explain'=>'更新失败'
            ];
        }
        return $pink;
    }
}