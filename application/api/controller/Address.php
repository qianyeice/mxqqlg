<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/22
 * Time: 9:29
 */
namespace app\api\controller;
use app\api\model\Member_address;
use apiController\apiController;



class Address extends apiController
{
    /**
     *  收货地址列表
     * @param $member_id 获取用户ID  $model $rlst
     * @return 返回查询后结果
     * 岳军章
     * 2018-3-22 9：20
    */
    public function lists()
    {
        ///获取用户ID
        $member_id = input('post.member_id');
        if(!is_null($member_id)){
            $model = new Member_address();
            //接收数据
            $data = $model->Address_lists($member_id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 收货地址添加
     * @param  $data 获取input值
     * @param $rlsts 接收数据
     * @return  return 返回数据
     * 岳军章        陈健英：改
     * 2018-3-22 11：20
     */

    public function add()
    {
        $member_id = input('post.member_id');
        $name = input('post.name');
        $mobile = input('post.mobile');
        $address = input('post.address');
        $is_default = input('post.is_default');
        $detailed = input('post.detailed');
        if(!is_null($member_id)&&!is_null($name)&&!is_null($mobile)&&!is_null($address)&&!is_null($is_default)&&!is_null($detailed)){
            $model = new Member_address();
            $data=array(
                'member_id' =>$member_id,
                'name'=>$name,
                'mobile'=>$mobile,
                'address'=>$address,
                'is_default'=>$is_default,
                'detailed'=>$detailed,
            );
            //接收数据
            $data = $model->Address_add($data);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }



    /**
     * 修改收货地址
     * @param  $data/$id 获取input值
     * @param $rlsts 接收数据
     * @return return 返回数据
     * 岳军章        陈健英：改
     * 2018-3-24 10：00
     */

    public  function modify()
    {
        //获取input值
       $id = input('post.id');
       $name = input('post.name');
       $mobile = input('post.mobile');
       $address = input('post.address');
       $is_default = input('post.is_default');
       $detailed = input('post.detailed');
        if(!is_null($id)&&!is_null($name)&&!is_null($mobile)&&!is_null($address)&&!is_null($is_default)&&!is_null($detailed)){
            $data=array(
                'name'=>$name,
                'mobile'=>$mobile,
                'address'=>$address,
                'is_default'=>$is_default,
                'detailed'=>$detailed,
            );
            $model = new Member_address();
            $data = $model->Address_modify($id,$data);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 删除收货地址
     * @param  $id 获取收货地址ID
     * @param $delete 接受数据
     * @return return 返回数据
     * 岳军章
     * 2018-3-23 14：00
     */
    public function delete()
    {
        $id = input('post.id');
        if(!is_null($id)){
            $model = new Member_address();
            $data = $model->Address_delete($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    /**
     * 设置默认收货地址
     * @param  $id 收货地址ID;  $mid：用户id
     * @param $delete 接受数据
     * 冯云祥
     */
    public function is_moren()
    {
        $id = input('id');
        $mid = input('mid');
       if(!is_null($id)&&!is_null($mid) ){
            $model = new Member_address();
            $data = $model->Address_is_moren($mid,$id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}