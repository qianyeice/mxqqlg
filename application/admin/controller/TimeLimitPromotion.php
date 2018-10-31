<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/29
 * Time: 11:03
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\pr_spu_sku;
use app\admin\model\Promotion_commodity;
use app\admin\model\View_goods_sku_spec;
use app\admin\model\Promotion_commodity_relation;
use app\admin\model\View_promotion_commodity;
use app\admin\model\Procominfor;
use GuzzleHttp\Promise\AggregateException;
use think\facade\Request;;
use qiniuSdk\qiniuSdk;
class TimeLimitPromotion extends adminController
{
    /**
     * 限时促销主页
     * time：18-3-29 14:16
     * author:蒲胜平
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        $start =(input('page')) ? input('page')+1 : 1;
        $limit =(input('limit')) ? input('limit') :20;
        $view_promotion=new View_promotion_commodity();
        $data=$view_promotion->get_data($start,$limit);
        $this->assign("count",$data['count']);
        $this->assign('limit',$limit);

        if($data){
            $this->assign("data",$data['data']);
            $this->assign("type",1);
        }else{
            $this->assign("type",0);
        }
        return view();
    }

    /**
     * 限时促销编辑
     * author:蒲胜平
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit(){
        $id=Request::get('id');
        $view_promotion=new View_promotion_commodity();
        $data=$view_promotion->edit_select($id);
        $this->assign("data",$data['data']);
        $this->assign("fxname",$data['fxname']);
        return view();
    }
    public function primg(){
        $id=input();
        $view_promotion=new View_promotion_commodity();
        $data=$view_promotion->seimg($id['id']);
        echo json_encode($data);
    }
    public function prtion(){
       $id=input();
        $promotion=new Promotion_commodity_relation();
        $data2=$promotion->edit_spu_select($id['id']);
        echo json_encode($data2);
    }
    /**
     * 限时促销移除商品
     * @return array 返回操作状态包
     */
    public function remove(){
        //接收商品ID
        $id=Request::post('id');
        $promotionID=Request::post('promotionID');
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->romove_spu($id,$promotionID);
        return $data;
    }

    /**
     * 选择商品页面显示查询
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    /**
     * author:蒲胜平
     * 2018.7.3
     * @return \think\response\View
     */
    public function choice_spu(){
        $view_goods_sku=new pr_spu_sku();
        $kot = new Procominfor();
//        传输品牌的数据
          $apples = $kot->brand();
        $type=isset($_GET["type"])?$_GET["type"]:2;
        $suo=input('keyword');
        $catid=input('catid');
        $bran_id=input('barnd');
        $start = input('page') ? input('page')+1 : 0;
        $limit = input('limit') ? input('limit') :5;
        $data=$view_goods_sku->get_sku($suo,$catid,$bran_id,$start,$limit);
        $this->assign("limit",$limit);
        $this->assign("count",$data['count']);
        $this->assign("data",$data['data']);
        $this->assign("brand",$apples);
        $this->assign("type",$type);
        return view();
    }

    /**
     * 限时抢购商品新增
     * @return array 返回操作状态数据包
     * @throws \Exception.AggregateException
     */
    public function Commodity_addition(){
        $array=array();
        //id组获取
        $id_data=Request::post('data/a');

        if(gettype  ($id_data)!="array"){
            $array["type"]=2;
            return $array;
        }
        $id=Request::post('id');

        $promotion=new Promotion_commodity_relation();
        $data=$promotion->Add_goods($id_data,$id);
       return $data;
    }

    /**
     * 限时抢购商品库存修改
     * @return array 操作状态返回
     *
     */
    public function Inventory_modification(){
        $id=Request::post('id');
        $number=Request::post('number');
        $promotionID=Request::post('promotionID');
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->Inventory_modification($id,$number,$promotionID);
        return $data;
    }

    /**
     * 限时抢购价格修改
     * @return array 操作状态返回
     */
    function ceshi(){


    }
    public function prup(){
        $data=input();
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->Price_modification($data);
        return $data;
    }

    /**
     * 限时抢购删除
     * @return array
     */
    public function delete(){
        $id=Request::post("id");
        $promotion=new Promotion_commodity();
        $data=$promotion->promotion_delete($id);

        return $data;
    }


    public function Time_limit_deleting(){
        $idArray=Request::post("idArray/a");
        $promotion=new Promotion_commodity();
        $data=$promotion->Time_limit_deleting($idArray);
        return $data;
    }
    /**
     * 限时抢购信息编辑；
     * @return array
     */
    public function Editor_submission(){
        $promotion=input('aggregate');
        $id=input('id');
        $objUrl=input('objUrl');
//        $promotion=json_decode($promotion);
        $a=new qiniuSdk();
        $name='xianshi'.time();
        $file_tmp=$objUrl;
        $b=$a->q_upload($name,$file_tmp);
//        $obj_array=$this->object_array($promotion);
//        $obj_array["start_time"]=strtotime($obj_array["start_time"]);
//        $obj_array["end_time"]=strtotime($obj_array["end_time"]);
//        $promotion_commodity=new Promotion_commodity();
//        $data=$promotion_commodity->Editor_submission($obj_array,$id);
        return $a;
    }

    /**
     * 超类转数组
     * @param $array 待处理的超类对象
     * @return array 处理后的数组对象
     */
    private function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key]=$this->object_array($value);
            }
        }
        return $array;
    }
}