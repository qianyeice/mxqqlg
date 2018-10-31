<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/4/10
 * Time: 10:54
 */

namespace app\admin\model;

use qiniuSdk\qiniuSdk;
use think\Db;
use think\Model;

class Promotion_commodity_relation extends Model
{
    /**
     * 促销商品查询
     * @param $id 限时促销id
     * @return bool 数据状态判定
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit_spu_select($id)
    {
        $data = $this->alias("a")
            ->field("k.sku_name,p.thumb,p.name,k.number,k.shop_price,a.spu_number,a.spu_price,k.id")
            ->join("goods_sku k", "a.spu_id=k.id")
            ->join("goods_spu p", "p.id=k.spu_id")
            ->where("Promotion_commodity_id", $id)->select();// 类的属性不存在-》sku_id
        return $data;
    }

    /**
     * 限时促销商品移除
     * @param $id 商品id
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态包
     */
    public function romove_spu($id, $promotionID)
    {
        $data = $this->where("spu_id", $id)
            ->where("Promotion_commodity_id", $promotionID)->delete();
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = "已下架";
        } else {
            $array["type"] = 0;
            $array["lang"] = "网络错误，下架失败。";
        }
        return $array;
    }

    /**
     * 商品限时抢购上架
     * @param $zhi 待处理的商品id
     * @param $id 限时抢购ID
     * @return array 操作状态
     * @throws \Exception
     */
    public function Add_goods($zhi, $id)
    {
        $spuid_array = array();
        foreach ($zhi as $k => $v) {
            if ($v != null) {
                $spuid_array[] = [
                    "spu_id" => $v,
                    "Promotion_commodity_id" => intval($id),
                ];
            }
        }
        $data = $this->saveAll($spuid_array);
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = "商品添加成功";
        } else {
            $array["type"] = 0;
            $array["lang"] = "网络错误，请稍后重试";
        }
        return $array;
    }

    /**
     * 库存修改
     * @param $id 商品ID
     * @param $number 库存修改量
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态
     */
    public function Inventory_modification($id, $number, $promotionID)
    {
        $data = [
            "spu_surplus_number" => $number
        ];
        $data = $this->where("spu_id", $id)
            ->where("Promotion_commodity_id", $promotionID)->data($data)->update();
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = "库存已修改";
        } else {
            $array["type"] = 0;
            $array["lang"] = "库存修改失败，请稍后重试";
        }
        return $array;
    }
    /**
     * 库存修改
     * @param $id 商品ID
     * @param $number 库存修改量
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态
     */
    public function Inventory_jiage($id, $number, $promotionID)
    {
        $data = [
            "spu_price" => $number
        ];
        $data = $this->where("spu_id", $id)
            ->where("Promotion_commodity_id", $promotionID)->data($data)->update();
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = "价格已修改";
        } else {
            $array["type"] = 0;
            $array["lang"] = "价格修改失败，请稍后重试";
        }
        return $array;
    }

    /**
     * 折扣价格修改
     * @param $id 商品ID  陈健英
     * @param $price 限时抢购价
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态
     */
    public function Price_modification($data)
    {


        $ii = -1;
        $qiniu = new qiniuSdk();
        $pro_pz_id = $data['prod_id'];             //   promotion_commodity    id
        $pro_pz_data = $data['prod'];                                        //修改的数据
        $pro_pz_img = $data['img'];                                          //图片
        $pro_spu = $data['spu'];
        foreach ($pro_pz_img as $p){
                     $ii++;
                     $name = 'xianshi/cuxiao/' . md5(time());
                     $file = 'http://p5od7vvyw.bkt.clouddn.com/xianshi/cuxiao/992a1c552b43cb44df3e682ad2d8b3c0';
                     $s=$qiniu->q_upload($name, $file);
                     $log[$ii] = 'http://p5od7vvyw.bkt.clouddn.com/' . $name;
        }

        $fname=explode(',',$pro_pz_data['fname']);
        $xname=explode(',',$pro_pz_data['xname']);
        for ($k=0;$k<count($fname);$k++){
            $sp['img']=$log[$k];
            $sp['name']=$fname[$k];
            $sp['spu_name']=$xname[$k];

            $josn[$k]=json_encode($sp);
        }
          $pro_pz_data['img']=implode(',',$josn);
         //组装
        $pro_pz_add['name']=$pro_pz_data['name'];
        $pro_pz_add['start_time']=time($pro_pz_data['start_time']);
        $pro_pz_add['end_time']=time($pro_pz_data['end_time']);
        $pro_pz_add['is_display']=$pro_pz_data['is_display'];
        $pro_pz_add['number']=$pro_pz_data['number'];
        $pro_pz_add['remain_sku_num']=$pro_pz_data['remain_sku_num'];
        $pro_pz_add['img']=$pro_pz_data['img'];
        $xiugai=Db::name('promotion_commodity')->where('id',$pro_pz_id)->update($pro_pz_add);
        if($xiugai<1){
            dump('xiugai');
            exit;
        }
        $shangchu=Db::name('promotion_commodity_relation')->where('Promotion_commodity_id',$pro_pz_id)->delete();
        if($shangchu<1){
            dump('xiugai');
            exit;
        }
        foreach ($pro_spu as $spu) {
            $add['Promotion_commodity_id'] = $pro_pz_id;
            $add['spu_id'] = $spu['id'];
            $add['spu_number'] = $spu['spu_number'];
            $add['spu_price'] = $spu['spu_price'];
            $zh=Db::name('promotion_commodity_relation')->insert($add);

        }
        if($zh<1){
            dump('xiugai');
            exit;
        }
        $array = array();
        if ($zh) {
            $array["type"] = 1;
            $array["lang"] = "价格已修改";
        } else {
            $array["type"] = 0;
            $array["lang"] = "价格修改失败，请稍后重试";
        }
        return $array;
    }

    /**
     * 活动商品添加
     * @param $val活动id
     * @param $spuData活动商品
     */
    function time_promotion_sku($val, $spuData)
    {
        foreach ($spuData as $vo) {
            $array = array(
                'Promotion_commodity_id' => $val,
                'spu_id' => $vo['id'],
                'spu_number' => $vo['active_inventory'],
                'spu_surplus_number' => $vo['active_inventory'],
                'spu_price' => $vo['activity_price']
            );
            $data = $this->insert($array);
        }
        $arr = array();
        if ($data) {
            $arr["type"] = 1;
            $arr["lang"] = "添加成功";
        } else {
            $arr["type"] = 0;
            $arr["lang"] = "添加失败";
        }
        return $arr;
    }

    /**
     * 秒杀活动限量
     * author:蒲胜平
     * @param $id 商品ID
     * @param $price 限时抢购价
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态
     * time 2018-4-19 16:30
     */
    public function spu_number($id, $number, $promotionID)
    {
        $data = [
            "spu_number" => $number
        ];
        $data = $this->where(["spu_id" => $id, "Promotion_commodity_id" => $promotionID])
            ->data($data)->update();
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = "活动限量已修改";
        } else {
            $array["type"] = 0;
            $array["lang"] = "活动限量修改失败，请稍后重试";
        }
        return $array;
    }

    /**
     * 秒杀活动单人限购
     * author:蒲胜平
     * @param $id 商品ID
     * @param $price 限时抢购价
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态
     * time 2018-4-19 16:30
     */
    public function sup_personal($id, $price, $promotionID)
    {
        $data = [
            "sup_personal" => $price
        ];
        $data = $this->where("spu_id", $id)
            ->where("Promotion_commodity_id", $promotionID)->data($data)->update();
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = "单人限购已修改";
        } else {
            $array["type"] = 0;
            $array["lang"] = "单人限购修改失败，请稍后重试";
        }
        return $array;
    }

    /**
     * 修改
     * @param $id 商品ID
     * @param $price 限时抢购价
     * @param $promotionID 限时抢购ID
     * @return array 返回操作状态
     * time 2018-4-19 16:30
     */
    public function relation_edit($id, $data)
    {
        $sql = $this->where(['Promotion_commodity_id' => $id])->update($data);
        $array = [];
        if ($sql) {
            $array = $sql;
        } else {
            $array['lang'] = "失败";
        }

        return $array;
    }

    public function fdele($id)
    {
        return $this->where('Promotion_commodity_id', 'in', $id)->delete();
    }

    /* public function relation_add($data)
     {
         $add = $this->save($data);

         return $add;
     }*/
}