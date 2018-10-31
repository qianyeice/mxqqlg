<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/12
 * Time: 9:40
 */

namespace app\admin\model;
use think\Model;

/**
 * 奖品配置
 * name:岳军章
 * time:2018 04 12 9:25
 * Class Lottery_prize
 */
class Lottery_prize extends Model
{
    /**
     * 奖品配置总数量
     * $number 查询
     * @return $array
     * name 岳军章
     * time 2018 04 12 14:00
     */
    public function number($id)
    {
        $number = $this
            ->where('lottery_id',$id)
            ->field('id')
            ->select();

        return count($number->toArray());
    }
    /**
     * 奖品配置列表
     * $number 查询
     * @return $array
     * name 岳军章
     * time 2018 04 12 14:30
     */
    public function lists($lottery_id,$start,$count)
    {
        $lists = $this
            ->where('lottery_id',$lottery_id)
            ->page($start, $count)
            ->order('id', 'desc')
            ->select();

        return $lists->toArray();
    }

    /**
     * 奖品配置数据查询
     * @param $id
     * @param $sql 查询
     * @return $array 返回值
     * name 岳军章
     * time  2018-04-12 10:46
     */
    public function prize_find($id)
    {
        $sql = $this->where('id',$id)->find();
        if (count($sql)>0){
            $array= $sql->toArray();
        } else {
            $array = "没有数据";
        }
        return $array;
    }

    /**
     * 奖品配置添加/修改
     * @param $id $data获取参数
     * @param $sql 接收添加/修改数据
     * @return $array 返回值
     * name 岳军章
     * time  2018-04-12 15:40
     */
    public function prize_edit($id,$data)
    {
        if ($id == null) {
            $sql = $this->save($data);
        } else {
            $sql = $this
                ->where(['id'=>$id,'lottery_id'=>$data['lottery_id']])
                ->update($data);
        }
        if ($sql) {
            $array = $sql;
        } else {
            $array ="fail";
        }
        return $array;

    }

    /**
     * 吴杰
     * 删除奖项
     * @param $id 删除的奖项id
     */
    public function dele($id){
        $da=$this->where('id','in',$id)->delete();
        return $da;
    }

}