<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 11:14
 */
namespace  app\api\model;
use think\Model;
class national extends Model{

    /**
     * 全国店铺经纬度
     * author:冯云祥
     */
    public function index($add){
        $data=$this->where('acc',$add)->select();
          if(count($data)>0){
              $array["type"]=1;
              $array["lang"]=lang('success');
          }else{
              $array["type"]=0;
              $array["lang"]=lang('noData');
          }
        $array["data"]=$data->toArray();
          return $array;
    }


}