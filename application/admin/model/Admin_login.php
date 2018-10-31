<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13
 * Time: 10:42
 */
namespace app\admin\model;
use think\Db;
use think\Model;
use think\facade\Session;
class Admin_login extends Model {
    /**
     * 用于登录时数据查询
     * 吴正勇  2018.3.20
     * $name:账号 $pwd:密码
     */
    public function admin_login($name,$pwd){
        $data=Db::table('admin_user')
            ->where('username',$name)
            ->where('password',$pwd)
            ->select();
        if(count($data)!=0){
            //获取当前时间戳

            $time= time();
            $num =$data[0]['number'];
            //根据条件修改登录时间  登录次数
            $date=Db::name('admin_user user')
                ->where('user.username',$name)
                ->where('user.password',$pwd)
                ->update([
                    'user.last_login_time'=> ['exp',$time],
                    'user.number'=> ['exp',$num +1],
                ]);
           session('id',$data[0]['id']);
            return $date;

        }else{
            return false;
        }

    }
}