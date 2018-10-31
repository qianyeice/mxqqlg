<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/24
 * Time: 14:42
 */

namespace app\api\model;

use think\Db;
use think\Model;
class Member_op extends Model{
    /**
     * 侯智
     * 查询是否该微信是否创建账户
     * @param $openid
     * @return bool
     */
         public function seopenid($openid){
             $data=Db::table('member_op')->where('opid',$openid)->select();
             if(count($data)>0){
                 return true;
             }else{
                 return false;
             }
         }
}
