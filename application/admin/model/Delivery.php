<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\11 0011
 * Time: 9:29
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class Delivery extends Model {
    function query(){
        $datas=Db::table('delivery')->where('is_delete',0)->select();
        return $datas;
    }
    function querys($start,$limit){
        $datas=Db::table('delivery')->where('is_delete',0)->page($start,$limit)->select();
        for ($i=0;$i<count($datas);$i++){
            if ($datas[$i]['enabled']==1){
                $datas[$i]['enabled']='✔';
            }elseif ($datas[$i]['enabled']==0){
                $datas[$i]['enabled']='╳';
            }
        }
        if(count($datas)>0){
            $array=$datas;
        }else{
            $array=lang('noData');
        }
        return $array;
    }
    function deletes($id){
        $data=Db::name('delivery')
            ->where('id', $id)
            ->update(['is_delete' => '1']);
        $array=[];
        if ($data){
            $array=[
                'type' => '1',
                'lang'=>lang('Delete_success')
            ];
        }else{
            $array=[
                'type' => '0',
                'lang'=>lang('Delete_failure')
            ];
        }
        return $array;
    }

    /**
     * 确认发货页面，物流信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function logistics_confirm()
    {
        $data=$this->field('id,name')->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
        }
        $array["data"] = $data;
        return $array;
    }
}