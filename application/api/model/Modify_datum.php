<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/10
 * Time: 15:45
 */
namespace  app\api\model;
use qiniuSdk\qiniuSdk;
use think\Model;
use think\Db;
class Modify_datum extends Model{
    /**
     * @param $id
     * @param $username
     * @param $mobile
     * @param $avatar
     * @return mixed
     */
    function modifydatum($id,$username,$mobile,$avatar){


        $up["username"] = $username;
        $up["mobile"] = $mobile;
        $a=new qiniuSdk();
        $filename=md5(time());

        if(!empty($avatar)){
            $file_tmp=$avatar;
            $b=$a->q_upload($filename,$file_tmp);
            $logo='http://p5od7vvyw.bkt.clouddn.com/'.$b['key'];
            $up["avatar"] = $logo;
        }
            $data = Db::table('member')->where("id",$id)->update($up);

            if($data==0){
                $array["type"]=0;
                $array["lang"]=lang('error');
            }else{
                $array["type"]=1;
                $array["lang"]=lang('success');
            }

        return $array;
    }
}
