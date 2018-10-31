<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/4/10
 * Time: 15:21
 */
namespace app\admin\model;
use think\Model;
class View_goods_sku_spec extends Model{
    /**
     * 数据分页显示查询
     * @param $page 当前页
     * @param $limit 页显示数
     * @return array 数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_sku($page,$limit){
        $data=$this->page($page,$limit)->order("id")->select();
//        dump($data);
//        exit;
        return $data->toArray();
    }
    /**
     * 商品总量查询
     * @return int 商品总量
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function count_sku(){
        $data=$this->field("id")->select();
        return count($data);
    }

    public function goods_sku($v){
        $data=$this->where('id',$v)->field("id,sku_name,sn,spec,thumb,number,shop_price,name,value")->order("id")->select();
        return $data->toArray();
    }
}