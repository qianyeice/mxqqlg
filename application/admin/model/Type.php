<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24
 * Time: 14:46
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Type extends Model
{
    function ready(){
        $where['status']=['<>',2];
        $data =$this->where($where)->select();
        return $data;
    }
    function read($start,$limit)
    {
        $where['status']=['<>',2];
        $data =$this->where($where)->page($start,$limit)->select();

        return $data;
    }

    function sel($id){
        $data = Db::table('type_spec')->where('id',$id)->find();

        return $data;
    }

    function adds($id,$name,$status,$spec_id,$text)
    {
        $dat = ['name' => $name, 'typeson_id' =>$spec_id,'status'=>$status,'content'=>$text];
        $data=Db::table('type')->insert($dat);
        return $data;
    }
    function newsave($id,$name,$status,$spec_id,$text){

        $data=Db::table('type')->where('id', $id)->update(['name' => $name, 'typeson_id' =>$spec_id,'status'=>$status,'content'=>$text]);

        return $data;
    }


    /**
     * 对商品类型数据进行更新(启用/关闭)
     * user:李天
     * @param $id 分类id
     * @param $close 更新类别
     * @return $this 更新状态(0/1)
     */

    public function close($id, $close)
    {
        if ($close == 2) {
            $data = $this->return_closes($id);

        } else {
            $data = $this->return_close($id, $close);
        }
        return $data;
    }


    /**
     * 数据启用/关闭操作
     * user:李天
     * @param $id
     * @param $close
     * @return $this
     */
    private function return_close($id, $close)
    {
        $where['id']=['=',$id];
        $where['status']=['<>','2'];
        $data = $this->where($where)->update(['status' => $close]);
        return $data;
    }

    /**
     * 数据删除操作
     * user:李天
     * @param $id
     * @param $close
     * @return $this
     */

    private function return_closes($id)
    {

        $data = $this->where("id",$id)->update(['status'=> 2]);

        return $data;
    }

    /**
     *吴杰
     * 全选删除
     * @param $id
     */
    public function delet($id){
        $where['id']=['in',$id];

        $data = $this->where($where)->update(['status'=> 2]);

        return $data;
    }
}