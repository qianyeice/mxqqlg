<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/4
 * Time: 11:56
 */

namespace app\admin\model;
use think\Model;


class Lottery extends Model
{
    /**
     * 抽奖活动列表查询总数量
     * name 岳军章
     * time  2018-04-8 10:46
     */
    public function nub()
    {
        $data=$this->field("id")->select();
        return count($data->toArray());
    }
    /**
     * 抽奖活动列表查询每页数量
     */
    public function lottery_list($start, $count)
    {
     /* $where['id'] = ['>', '0'];
        $data = listPage('id,name,img,start_time,end_time,frequeny,is_display,content,explain,date' ,$where, $start, $count, $this);
       //dump($data);exit;

        return $data;*/

       $lists = $this
            ->limit($start, $count)
            ->order('id', 'desc')
            ->select();

        return $lists->toArray();

    }


    /**
     * 抽奖活动数据查询
     * @param $id
     * @param $sql 查询
     * @return $array 返回值
     * name 岳军章
     * time  2018-04-8 10:46
     */
    public function lottery_find($id)
    {
        //查询数据
        $sql = $this->where(['id'=>$id])->find();
        $array = [];
        if (count($sql)>0){
            $array['data']= $sql->toArray();
        } else {
            $array['lang'] = "no_data";
            $array['data']= $sql;
        }
        return $array;
    }

    /**
     * 抽奖活动添加/修改
     * @param $id $data获取参数
     * @param $sql 接收添加/修改数据
     * @return $array 返回值
     * name 岳军章
     * time  2018-04-8 10:46
     */
    public function add_modify($id,$data)
    {
        if($id ==null) {
            $sql = $this->save($data);
        } else {
           $sql = $this->where(['id'=>$id])->update($data);
        }
        return $sql;
    }

    /**
     * 吴杰
     * 抽奖活动单、多项删除
     * @param $id
     */
    public function dele($id){
        $da=$this->where('id','in',$id)->delete();
        return $da;
    }

}