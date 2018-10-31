<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/27
 * Time: 15:18
 */
namespace app\api\model;
use think\Model;
class Wechat_payment extends Model{
    /**
     * 微信配置获取
     * time :18-3-27 15:26;
     * author:陈明福
     * @return array 返回微信config
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function weChatConf(){
        $data=$this->where("id",1)->select();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]="success";
            $array["data"]=$data->toArray();
        }else{
            $array["type"]=0;
            $array["lang"]="noData";
            $array["data"]='';
        }
        return $array;
    }



    /**
     * 微信配置获取
     * time :18-3-27 15:26;
     * author:冯云祥
     * @return array 返回微信config
     */
    public function index(){
        $data=$this->where("operation",0)->find();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]=lang("success");
            $array["data"]=$data->toArray();
        }else{
            $array["type"]=0;
            $array["lang"]=lang("peizhi");
            $array["data"]='';
        }
        return $array;
    }
}