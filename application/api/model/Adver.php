<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 11:14
 */
namespace  app\api\model;
use think\Model;
use think\Db;
use carousel\carousel;
class Adver extends Model{

    /**
     * 数据库查询并缓存数据 首页轮播图
     * time:18-3-20 15:20
     * author:陈明福
     * @return mixed 返回数据查询结果
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */


//    接口已确认，app+微信，7月17
    public function getHomeCarousel(){
        //定义查询条件数组
        $data=[
//            轮播位置
            'type'=>'1',
//            是否显示
            'is_display'=>'1',
//            是否删除
            'is_delete'=>'1'
        ];
        $carousel=$this->field("id,url,img_url")->cache(7200)->where($data)->select();
        $array=array();
        if(count($carousel)>0){
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$carousel->toArray();
        return $array;
    }

//    public function tongzhi(){
//        $table = new Adver();
//        $signt = $table->continuous();
//        return $this->apiReturn($signt['type'], $signt['lang'], $signt['data']);
//    }


}