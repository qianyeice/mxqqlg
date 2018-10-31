<?php
namespace  app\api\model;
use think\Model;
use think\Db;
use carousel\carousel;

/**
 * ���ݿ��ѯ���������� ��ҳ֪ͨ
 * time:18-5-24 13:24
 * author:������
 * @return mixed �������ݲ�ѯ���
 */

//接口已确认，app+微信，7月17
class Config extends Model{
//tz
    public function tong(){
        $data = Db::table("config")->where('name','sy')->field('value,is_display')->find();
        $array=array();
        if(count($data)==0){    //关
            $array["type"]=0;
            $array["lang"]='error';
        }else{           //开
            $array["type"]=1;
            $array["lang"]='success';
        }
        $array["data"]=$data;
//        var_dump($array);
//        exit;
        return $array;
    }
}