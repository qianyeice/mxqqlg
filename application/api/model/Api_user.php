<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 11:14
 */
namespace  app\api\model;
use think\Model;
use think\Db;
class Api_user extends Model{

    /*
     * @param $appid:用户appid
     * @param $appsecret:用户appsecret
     * 获取我们的Token（获取后才能调接口）
     * Time: 2018\4\2  10:05 name：冯云祥
     */
    public function getMyToken($appid,$appsecret){
        $url=$_SERVER['SERVER_NAME'];
        if(cache($url)){
            $array["type"]=1;
            $array["lang"]=lang('Token');
            $array["data"]=cache($url);
        }else{
            $sql=array(
                'appid' => $appid,
                'appsecret' => $appsecret,
            );
            $Token=$this->where($sql)->select();
            if($Token){
                $string=rand(0,99).$appid.time();
                $array["type"]=1;
                $array["lang"]=lang('success');
                $array["data"]=base64_encode($string);
                cache($url,$array["data"],7200);
            }else{
                $array["type"]=0;
                $array["lang"]=lang('noData');
            }
        }
        return $array;
    }
}