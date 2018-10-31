<?php

namespace app\api\model;
use think\Db;
use think\Model;

class Member_address extends Model
{
    protected $pk = 'id';

    /**
     * @param $id传入用户id
     * @return mixed 返回默认收货地址
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 丁龙
     * 18.3.27
     * 17:37
     */
    public function ReceivingAddress($id)
    {
        $cxjg = $this
            ->field('id,member_id,name,mobile, address,is_default,detailed')
            ->where(array(
                'member_id' => $id,
                'is_default'=>'1'
            ))->select();
        $array=array();
        if(count($cxjg)>0){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$cxjg->toArray();
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]='';
        }
        return $array;
    }

    /**
     * 收货地址列表
     * @param $member_id 获取用户id   $sql
     * @return false|\PDOStatement|string|\think\Collection 返回数据
     * 岳军章
     * 2018-3-22 9：20
     */
    public function Address_lists($member_id)
    {
        //查询当前用户为 member_id 的所有收获地址
        $sql = $this->where('member_id',$member_id)->select();
        $array=array();
        if(count($sql)>0){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$sql->toArray();
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]='';
        }
        return $array;

    }

    /**
     * 收货地址添加  Address_add()
     * @param  $data 获取数据
     * @param   $sql 添加数据
     * @param  $array 定义当前返回数组参数
     * @return false|\PDOStatement|string|\think\Collection 返回数据
     * 岳军章            陈健英：改
     * 2018-3-22 11：20
    */
    public function Address_add($data)
    {
        //添加收货地址
        $sql = $this->validate ('Address1')-> save($data);
        //判断返回参数
        $array=array();
            if($sql){
                $array["type"]=1;
                $array["lang"]='success';
                $array["data"]=$sql;
            }else{
                $array["type"]=0;
                if(!$sql===false){
                    $array["lang"]='Add_failure';
                }else{
                    $array["lang"] =$this->getError();
                }
                $array["data"]=$sql;
            }
        return $array;
    }


    /**
     * 收货地址修改  Address_modify()
     * @param  $data $id 获取数据  $sql
     * @param  $array 定义当前返回数组参数
     * @return false|\PDOStatement|string|\think\Collection 返回数据
     * 岳军章
     * 2018-3-23 14：00
     */

    public  function Address_modify($id,$data)
    {
        //查询数据
        $rlts = $this->where('id',$id)->find();

        //判断返回参数
        $array=array();
        if (count($rlts)>0) {
            //修改数据
            $sql = $this->validate ('Address')->where('id',$id)->update($data);
            if ($sql) {
                $array["type"] = 1;
                $array["lang"] = 'success';
                $array["data"] = $sql;
            } else {
                $array["type"] = 0;
                if (!$sql===true) {
                    $array["lang"] = 'modify_faileds';
                } else {
                    $array["lang"] =$this->getError();
                }
                $array["data"] = $sql;
            }
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }


        return $array;
    }

    /**
     * 删除收货地址
     * @param  $id 获取收货地址ID
     * @param $sql 接受数据
     * @return return 返回数据
     * 岳军章
     * 2018-3-24 14：00
     */
    public function Address_delete($id)
    {
        $sql = $this->where('id',$id)->delete();
        $array=array();
        if($sql){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$sql;
        }else{
            $array["type"]=0;
            $array["lang"]='delete_faileds';
            $array["data"]=$sql;
        }
        return  $array;
    }


    /**
     * 修改默认收货地址
     * @param  $id 收货地址ID
     * 冯云祥
     */
    public function Address_is_moren($mid,$id)
    {
        $array=array();
//        $data = $this->save(['is_default'=>0],['member_id'=>$mid]);
            $this->where("member_id",$mid)->update(["is_default"=>"0"]);
//        select();
//        dump($data);exit;
//
//        if($data){
//            echo "1";exit;
//          $data = $this->save(['is_default'=>1],['member_id'=>$mid,'id'=>$id]);
            $data=$this->where("id",$id)->update(["is_default"=>"1"]);
//            dump($data);exit;
            if($data){
                $array["type"]=1;
                $array["lang"]=lang('success');
                $array["data"]=$data;
            }else{
                $array["type"]=0;
                $array["lang"]=lang('modify_faileds');
                $array["data"]=$data;
            }
//        }else{
//            $array["type"]=0;
//            $array["lang"]=lang('modify_faileds');
//            $array["data"]=$data;
//        }
        return $array;
    }
}
