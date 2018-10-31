<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/22
 * Time: 9:22
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\GoodsSpu;
use app\api\model\GoodsSku;
use app\api\validate;
class Search extends apiController {
    /**.
     * 根据用户输入的关键词 查询相应数据；
     * time:18-3-22 13:38
     * author:陈明福
     * @return array 返回数据包 成功返回会数据 失败则返回提示
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function commoditySearch(){
        //获取用户输入关键字
        $keyword=input('keyword');
//        $keyword='00063';
//        $shuru=preg_match("/[\x7f-\xff]/",$keyword);
//        if($shuru){}
//        else{
            $goodsSku=new GoodsSku();
            $data=$goodsSku->numberedSearch($keyword);
//        }
//        dump($data);exit;
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//        $result = $this->validate(
//            [
//                'keyword'  =>$keyword,
//            ],
//            'app\api\validate\Address');
//
//        if (true !== $result) {
//            // 验证失败 输出错误信息
//            return $this->apiReturn('0',$result,'');
//        }
//        //判断用户输入类型
//        if (preg_match("/[-]\d+$/",$keyword)) {
//            //副表搜索编号
//            $goodsSku=new GoodsSku();
//            $data=$goodsSku->numberedSearch($keyword);
//            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//        } else{
//            //主表货号搜索
//            $goodsSpu=new GoodsSpu();
//            $data=$goodsSpu->numberOfSearch($keyword);
//            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//        }
    }


    /**
     * 搜索页面新品促销商品
     * time:2018-5-24
     * author:胡伟
     * @return array
     */
    public function newProduct(){
        $types=input("types");
        $num=input("num");
        $goods=new GoodsSku();
        $data=$goods->product($types,$num);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }






}