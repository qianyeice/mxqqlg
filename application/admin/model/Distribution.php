<?php

namespace app\admin\model;

use think\Model;

class Distribution extends Model
{
    /**
     * time:18-4-10 14.34
     * name:邓剑
     * 查询全部没有删除的数据
     */
    public function disall($start,$limit)
    {
        return $this
            ->where('is_delete', '1')
            ->page($start,$limit)
            ->select();
    }

    /**
     * time:18-4-10 14.34
     * name:邓剑
     * 删除数据
     */
    public function disdele($id)
    {
        $updata = $this->where('id', $id)->setField('is_delete', '0');
        $array = [];
        if ($updata) {
            $array = [
                'type' => '1',
                'explain' => '删除成功'
            ];
        } else {
            $array = [
                'type' => '0',
                'explain' => '删除失败'
            ];
        }
        return $array;
    }

    /**
     * time:18-4-10 14.34
     * name:邓剑
     * 编辑 抓取单条数据
     */
    public function distake($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * time:18-4-10 14.34
     * name:邓剑
     * 编辑 更新数据
     */
    public function disupdata($array, $id)
    {
        $updata = $this->where('id', $id)->update([
            'name' => $array[0],
            'direct_sale' => $array[1],
            'indirect_sale' => $array[2],
            'direct_admin' => $array[3],
            'indirect_admin' => $array[4]
        ]);
        $number = [];
        if ($updata) {
            $number = [
                'type' => '1',
                'explain' => '更新成功'
            ];
        } else {
            $number = [
                'type' => '0',
                'explain' => '更新失败'
            ];
        }
        return $number;
    }
}