<?php

namespace app\admin\model;

use think\Model;

class Sed_toset extends Model
{
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * SED设置 view数据
     */
    public function sedall()
    {
        return $this->find();
    }

    /**
     * time:18-4-12 10.03
     * name:邓剑
     * SED设置  更新
     */
    public function sedupdata($id, $array)
    {
        $data = $this->where('id', $id)->update([
            'captionsuffix' => $array[0],
            'keywordsofmall' => $array[1],
            'keyworddescription' => $array[2],
            'otherheader' => $array[3],
        ]);
        $pink = [];
        if ($data) {
            $pink = [
                'type' => '1',
                'explain' => '更新成功'
            ];
        } else {
            $pink = [
                'type' => '0',
                'explain' => '更新失败'
            ];
        }
        return $pink;
    }
}