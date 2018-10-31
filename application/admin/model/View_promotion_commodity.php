<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/4/8
 * Time: 17:09
 */
namespace app\admin\model;

use think\Db;
use think\Model;

class View_promotion_commodity extends Model
{
    /**
     * 限时促销分页查询
     * author:蒲胜平
     * @param $page 当前页
     * @param $limit 显示数量
     * @return bool 无数据时状态
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_data($page, $limit)
    {
        $fin = "id,name,start_time,end_time,is_display,spu_id,number,spu_price,SUM(spu_number) as spu_number ,remain_sku_num as spu_surplus_number";
        $where['panduan'] = 1;
        $data = listP($fin, $where, $page, $limit, $this, false);
        if (count($data) > 0) {
            $array = array();
            foreach ($data['data']->toArray() as $k => $v) {
                $v["time"] = date("Y-m-d H:i:s", $v["start_time"]) . "-" . date("Y-m-d H:i:s", $v["end_time"]);
                if ($v["is_display"] == 1) {
                    $v["type"] = "进行中";
                } else {
                    $v["type"] = "已结束";
                }
                $array[$k] = $v;
            }
            $data['data'] = $array;

            return $data;
        } else {
            return false;
        }
    }


    /**
     * 限时促销总量获取
     * author:蒲胜平
     * @return int 限时促销总量
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function count_data()
    {
        $data = $this->field("id")->group("id")->select();
        return count($data->toArray());
    }

    /**
     * 限时抢购编辑数据包查询
     * author:蒲胜平
     *
     * @param $id 限时ID
     * @return array 限时抢购详情数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit_select($id)
    {
        $fname = null;
        $xname = null;
        $add=[];
        $data = Db::name('promotion_commodity')->where("id", $id)->group("id")->find();
        $data["start_time"] = date("Y-m-d H:i:s", $data["start_time"]);
        $data["end_time"] = date("Y-m-d H:i:s", $data["end_time"]);
        $data['img'] = json_decode('[' . $data['img'] . ']', true);
        foreach ($data['img'] as $dd) {
            $fname .= $dd['name'] . ',';
            $xname .= $dd['spu_name'] . ',';
        }
        $fxname['fname'] = rtrim($fname, ',');
        $fxname['xname'] = rtrim($xname, ',');
        $add['data']=$data;
        $add['fxname']=$fxname;
        return $add;
    }
    public function seimg($id){
        $data = Db::name('promotion_commodity')->where("id", $id)->group("id")->find();
        $data['img'] = json_decode('[' . $data['img'] . ']', true);
        return $data['img'];
    }

}