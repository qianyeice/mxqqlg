<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/5/10
 * Time: 19:06
 */
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 * 登录查询权限
 * 吴杰
 * Class Admin_user
 * @package app\admin\model
 */
class Admin_user extends Model {
    public function sele($id){
        $con=$this->field("is_supplier,jurisdiction_id")->where("id",$id)->select();
        $arr=explode(",",$con[0]["jurisdiction_id"]);
        for($i=0;$i<count($arr);$i++)
        {
            $arr[$i] = intval($arr[$i]);
        }
        return $arr;
    }
    public function user($id){
        $this->where('id',$id)->find()->select();
    }
    public function memu(){
        $table=Db::name('admin_memu')->select();
        $digui=$this->list_to_tree($table);
        return $digui;
    }
    function list_to_tree($list, $pk='id', $pid = 'pid', $child = 'child', $root = 0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

//    添加管理
    public function member_add($data){
        $cation= implode(',',$data['rules']);
        $add=[
            'username'=>$data['username'],
            'password'=>md5($data['password']),
            'last_login_time'=>time(),
            'is_supplier'=>$data['is_supplier'],
            'jurisdiction_id'=>$cation,
            'bang_id'=>$data['barnd'],
            'text'=>$data['text']
        ];
        if($data['id']==0){
            return insert($add,$this);
        }else{
         return   modify($data['id'], $add, $this);
        }
    }

    public function da(){

        return $this->select();
    }

//            查询管理员
    public function admin_user($id){
        $wh=$this->where('id',$id['id'])->find();
        return $wh;
    }

//    删除
public function up($id){
    return    $this->where('id',$id['id'])->delete();
}

}