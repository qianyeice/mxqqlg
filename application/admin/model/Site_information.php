<?php

namespace app\admin\model;

use think\Model;

class Site_information extends Model
{
    /**
     * time:18-4-10 22.19
     * name:邓剑
     * 站点设置 - 站点信息 抓取数据
     */
    public function infall()
    {
        return $this->select();
    }

    /**
     * time:18-4-10 22.19
     * name:邓剑
     * 站点设置 - 站点信息 更新数据
     */
    public function infupdata($id, $array)
    {
        $updata = $this->where('id', $id)->update([
            'sitename' => $array[1],
            'firmname' => $array[2],
            'mallurl' => $array[3],
            'mallcode' => $array[4],
            'malltype' => $array[0],
            'typewhy' => $array[5]
        ]);
        $cyan = [];
        if ($updata) {
            $cyan = [
                'type' => '1',
                'explain' => '更新成功'
            ];
        } else {
            $cyan = [
                'type' => '0',
                'explain' => '更新失败'
            ];
        }
        return $cyan;

    }
}