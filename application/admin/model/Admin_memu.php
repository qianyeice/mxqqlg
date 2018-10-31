<?php
namespace app\admin\model;

use think\Db;
use think\Model;

/**
 * 数据库查找后台顶部、左部标题
 * Time: 2018\3\21  10:20
 * name：李磊
*/
class  Admin_memu extends Model{
    public function admin_topMenu(){
        $data=$this->query('call admin_top(0)');
        return $data[0];
    }
    public function admin_leftMenu($id=null){
        if($id==null){
            $data=$this->admin_topMenu();
          $id=$data[0]['id'];
        }
        $data=$this->query('call admin_left('.$id.')');
     return $data[0];
    }
    public function mydemo($id,$pid){
    $user=new Admin_user();
         $data=  $user->sele($id);
        $where['id']=['in',$data];
        $where['pid']=['=',$pid];
       $data= $this->where($where)->select();
    return $data;
    }
    public function leftdemo($pid){
        $data= $this->where('pid',$pid)->select();
        return $data;
    }
//    public function auth($id){
//        $user=new Admin_user();
//        $data=  $user->sele($id);
//        $num=request()->module();
//        $bum=request()->controller();
//        $aum=request()->action();
//        $where['id']=['in',$data];
//        $where['m']=['=',$num];
//        $where['c']=['=',$bum];
//        $where['a']=['=',$aum];
//        $data= $this->where($where)->select();
//    if(count($data)==0){
//        return false;
//    }else{
//        return true;
//    }
//    }
}