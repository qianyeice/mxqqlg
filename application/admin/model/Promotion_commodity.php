<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/4/12
 * Time: 17:47
 */

namespace app\admin\model;

use think\Db;
use think\Model;
use qiniuSdk\qiniuSdk;

class Promotion_commodity extends Model
{


    /**
     * 限时促销信息编辑
     * @param $data 修改数据包
     * @param $id 限时ID
     * @return array 状态数据包
     */
    public function Editor_submission($data, $id)
    {
        $returnData = $this->where("id", $id)
            ->update([
                'name' => $data['name'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'is_display' => $data['is_display'],
                'number' => $data['limit_num'],

            ]);

        $array = array();
        if ($returnData >= 0) {
            $array["type"] = 1;
            $array["lang"] = "修改成功";
        } else {
            $array["type"] = 0;
            $array["lang"] = "修改失败，请稍后重试";
        }
        return $array;
    }

    /**
     * 限时抢购删除
     * @param $id 限时抢购id
     * @return array 操作状态
     */
    public function promotion_delete($id)
    {
        $data = $this->where("id", $id)->delete();
        $array = array();

        if ($data > 0) {
            $array["type"] = 1;
            $array["lang"] = "已删除";
        } else {
            $array["type"] = 0;
            $array["lang"] = "删除失败，请稍后重试";
        }
        return $array;
    }

    /**
     * 限时抢购组删除
     * @param $data 待处理数据id组
     * @return array|false 操作状态
     */
    public function Time_limit_deleting($data)
    {
        $array = array();
        foreach ($data as $k => $v) {
            $array[] = [
                "id" => $v,
                "is_delete" => 0
            ];
        }
        $data = $this->saveAll($array);
        $retrun = array();
        if (count($data) > 0) {
            $retrun["type"] = 1;
            $retrun["lang"] = "已删除";
        } else {
            $retrun["type"] = 0;
            $retrun["lang"] = "系统错误，请稍后重试";
        }
        return $retrun;
    }

    public function promotion_temporary_add()
    {
        $data = $this->save();
        return $this->id;
    }

    /**
     * 添加活动返回id
     * @param $activity
     * @return int|string
     */
    function time_activity_add($acti)
    {
        $qiniu = new qiniuSdk();
        $img = json_decode($acti['prod']['img'], true);
        $josn=null;
        for ($ii = 0; $ii < count($img); $ii++) {
            $name = 'xianshi/cuxiao/' . md5(time());
            $file = $img[$ii]['base64'];
            $qiniu->q_upload($name, $file);
            $log[$ii] = 'http://p5od7vvyw.bkt.clouddn.com/' . $name;
            $sp['img']= $log[$ii];
            $sp['name']=$acti['prod']['fname'][$ii]?$acti['prod']['fname'][$ii]:'';
            $sp['spu_name']=$acti['prod']['xname'][$ii]?$acti['prod']['xname'][$ii]:'';
            $josn[$ii]=json_encode($sp);
        }

        $data['name']=$acti["prod"]["name"];
        $data['start_time']=strtotime($acti["prod"]['start_time']);
        $data['end_time']=strtotime($acti["prod"]['end_time']);
        $data['is_display']=$acti["prod"]["is_display"];
        $data['number']=$acti["prod"]["number"];
        $data['remain_sku_num']=$acti["prod"]["remain_sku_num"];
        $data["panduan"]=1;
        $data['img']=implode(',',$josn);
        $id = $this->insertGetId( $data);
        for ($w = 0; $w < count($acti["prod"]["sku_id"]); $w++) {
            $wh["Promotion_commodity_id"] = $id;
            $wh["spu_id"] = $acti["prod"]["sku_id"][$w];
            $wh["spu_number"] = $acti["prod"]["num"][$w];
            $wh["spu_price"] = $acti["prod"]["jiage"][$w];
           $f= Db::name('promotion_commodity_relation')->insert($wh);
        }

        if ($f) {
            $arr["type"] = 1;
            $arr["lang"] = "添加成功";
        } else {
            $arr["type"] = 0;
            $arr["lang"] = "添加失败";
        }
        return $arr;
    }

    /**
     * 修改活动返回id
     * @param $activity
     * @return int|string
     * name 岳军章
     * time 2018-4-19 15：00
     */
    public function commodity_edit($id, $edit1)
    {
        $sql = $this->where(['id' => $id])->update($edit1);
        $array = [];
        if ($sql) {
            $array = $sql;
        } else {
            $array['lang'] = "失败";
        }

        return $array;
    }

    public function dele($id)
    {
        return $this->where('id', 'in', $id)->delete();
    }


}