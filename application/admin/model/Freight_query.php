<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\12 0012
 * Time: 15:22
 */
namespace app\admin\model;
use think\Db;

class Freight_query{
    function query(){
        $data=Db::table('freight_formwork')
            ->where('is_delete',0)
            ->select();
        return $data;
    }
    function querys($start,$limit){
       $data=Db::table('freight_formwork')
           ->where('is_delete',0)
           ->page($start,$limit)
           ->select();
       if(count($data)>0){
           for ($i=0;$i<count($data);$i++){
               if($data[$i]['type']==1){
                   $data[$i]['type']=lang('By_weight');
               }elseif ($data[$i]['type']==2){
                   $data[$i]['type']=lang('Volume_by_volume');
               }elseif ($data[$i]['type']==3){
                   $data[$i]['type']=lang('Number_of_cases');
               }
           }
           return $data;
       }else{
           return lang('no_data');
       }
    }
    function deletes($id){
        $data=Db::name('freight_formwork')
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
    function batch_delete($id_array,$lenght){
        $a=0;
        for($i=0;$i<$lenght;$i++){
            $id= $id_array[$i];
            $data=Db::name('freight_formwork')
                ->where('id', $id)
                ->update(['is_delete' => '1']);
            $array=[];
            if ($data){
                $a++;
            }
        }
        if($a==$lenght){
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
}