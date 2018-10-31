<?php
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * 首页通知栏
 * Time: 2018\5\25  11:45
 * name：易婷婷
 */
class Config extends Model{

//首页通知 修改方法
    public function xiugai($data){
//        var_dump($data);
//        die();
        $is_display=Db::table('config')->where('name','sy')->select();

        if($is_display[0]['is_display']==1){    //开启
         $adda = $this->where('name','sy')->update(['value'=>$data]);
            return $adda;
        }else{
            return false;
        }
    }

//首页通知  关闭通知
    public function kaiguan($data){
//        var_dump($data);
//        die();
        $adda = $this->where('name','sy')->update(['is_display'=>$data]);
//        var_dump($adda);
//        die();
        return $adda;
    }

}