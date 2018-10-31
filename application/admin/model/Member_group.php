<?php
/**
 * Created by PhpStorm.
 * Name:谢岸霖
 * User: admin
 * Date: 2018/4/24
 * Time: 10:27
 */

namespace app\admin\model;

use think\Model;

class Member_group extends Model
{
    function set($id)
    {
        return $this->where(array('id' => $id))->select();
    }

    function add($name, $min, $max, $bonus, $wastage, $describe)
    {
        $data = [
            'id' => null,
            'name' => $name,
            'min_integral' => $min,
            'max_integral' => $max,
            'discount' => '',
            'share_ratio' => $bonus,
            'wear_ratio' => $wastage,
            'status' => '',
            'sort' => '',
            'description' => $describe,
            'sign_config' => '',
            'display' => '1'
        ];
        return $this->insert($data);
    }

    function updata($id, $name, $min, $max, $bonus, $wastage, $describe)
    {
        $data = [
            'id' => $id,
            'name' => $name,
            'min_integral' => $min,
            'max_integral' => $max,
            'discount' => '',
            'share_ratio' => $bonus,
            'wear_ratio' => $wastage,
            'status' => '',
            'sort' => '',
            'description' => $describe,
            'sign_config' => '',
            'display' => '1'
        ];
        return $this->save($data, $id);
    }

    function signin($id, $json)
    {
        return $this->where(array('id' => $id))->update(array('sign_config' => $json));
    }

    function del($id)
    {
        return $this->where("id",'in',$id)->update(array('display' => '0'));
    }

    /**
     * time:18-4-25
     * name:邓剑
     * //用户 - 全球分红 - 等级
     */
    public function level($all, $type)
    {
        $data = $this->where(array('display'=>'1'))->order("id")->select();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['red'] = $all * ($data[$i]['share_ratio'] / 100);
        }
        if ($type == '1') {
            return $this->my($data);
        } else {
            return $data;
        }
    }

    private function my($data)
    {
        $cyan = [];
        for ($i = 0; $i < count($data); $i++) {
            $num = strpos($data[$i]['red'], '.');
            if ($num) {
                $len = substr($data[$i]['red'], $num);
                if (strlen($len) == 2) {
                    $data[$i]['red'] = $data[$i]['red'] . '0';
                } else {
                    $data[$i]['red'] = $data[$i]['red'];
                }
            } else {
                $data[$i]['red'] = $data[$i]['red'] . '.00';
            }
            $cyan[$i] = $data;
        }
        return $cyan;
    }
}