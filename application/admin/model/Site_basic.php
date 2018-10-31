<?php

namespace app\admin\model;

use think\Model;

class Site_basic extends Model
{
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 基本设置 view数据
     */
    public function basall()
    {
        return $this->find();
    }

    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 基本设置 更新
     */
    public function basupdata($basid, $defaul, $logo)
    {
        $data = $this->where('id', $basid)->update([
            'malllogo' => $logo,
            'defaulttime' => $defaul[0],
            'areaclassification' => $defaul[1],
        ]);
        return $this->retrun($data);
    }

    private function retrun($data)
    {
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

    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 基本设置 更新
     */
    public function basupdatas($basid, $defaul)
    {
        $data = $this->where('id', $basid)->update([
            'defaulttime' => $defaul[0],
            'areaclassification' => $defaul[1],
        ]);
        return $this->retrun($data);
    }
}