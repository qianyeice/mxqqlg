<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\10 0010
 * Time: 14:45
 */
namespace Distribution_data_processing;
use app\admin\model\Distribution_management;
class Distribution_data_processing{
    /**
     * 物流配送设置数据处理
     * Date: 2018/4/10
     * Time: 14:52
     * User: 白锦国
     * $enabled是否开启该物流 1开启 0关闭
     * $name 物流名称
     * $identif 物流标识
     * $logo 上传成功后logo文件名（路径在根目录/uploads/ 目录下）
     * $sort排序
     */
    function data($enabled,$name,$identif,$logo,$sort,$adds){
        if($name!=null&&$identif!=null){
            $add=new Distribution_management();
            $array=$add->adds($enabled,$name,$identif,$logo,$sort,$adds);
        }else{
            $array=lang('cannot_be_empty').'<a href="?s=admin/distribution_logistics/index">点击返回</a>';
        }
        return $array;

    }
    function update($enabled,$name,$identif,$sort,$adds){

        $add=new Distribution_management();
        $array=$add->update($enabled,$name,$identif,$sort,$adds);
        if($array!=0){
            return $ad=["type"=>"编辑成功". '<a href="?s=admin/distribution_logistics/index">点击返回</a>',
            "id"=>1
            ];
        }
    }
}
