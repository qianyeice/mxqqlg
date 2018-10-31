<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\6 0006
 * Time: 17:26
 */
namespace app\admin\model;

//notification_system
use think\Db;

class Notification_system{
    /**
     * 通知系统表查询数据
     * Time: 2018\4\6  17:20
     * name：白锦国
     */
    function notification_system(){
       $data= Db::table('notification_system')->select();
       if(count($data)>0){
           for($i=0;$i<count($data);$i++){
               if($data[$i]['is_uninstall']==0){
                   $data[$i]['is_uninstall']=lang('uninstall');
               }elseif($data[$i]['is_uninstall']==1){
                   $data[$i]['is_uninstall']=lang('install');
               }if($data[$i]['type']==0){
                   $data[$i]['type']='×';
               }elseif($data[$i]['type']==1){
                   $data[$i]['type']='√';
               }
           }
           return $data;
       }else{
           return false;
       }
    }
    /**
     * 卸载支付方式
     * Time: 2018\4\6  18:10
     * name：白锦国
     */
    function uninstall($id,$is_uninstall){
        if($is_uninstall==lang('uninstall')){

           $data= $this->datas('1','0',$id);

        }elseif($is_uninstall==lang('install')){
           $data= $this->datas('0','1',$id);
        }
      return $data;
    }
    function datas($a,$b,$id){
        $data= Db::name('notification_system')->where('id',$id)
            ->update(
                ['is_uninstall' => $a]
            );
        $ass=Db::name('notification_system')->where('id',$id)
            ->update(
                ['type' => $b]
            );
        $array=[];
        if($data&&$ass){
            $array["lang"]=lang('success');
        }else{
            $array["lang"]=lang('fail');
        }
        return $array;
    }

}