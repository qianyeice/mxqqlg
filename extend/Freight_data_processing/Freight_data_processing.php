<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\14 0014
 * Time: 9:44
 */

namespace Freight_data_processing;

use app\admin\model\FreightTemplatequrey;

class Freight_data_processing
{
    /**
     * name:白锦国   运费模板编辑
     * time：2018 1 14
     * @param $data：form表单提交全部数据
     */
    function data_processing($data)
    {
        $fid = $data['freight_formwork_id'];
        $name = $data['name'];
        $type = $data['type'];
        $sort = $data['sort'];
        if($data['pid']!=""){
            $array=$this->template_Data_cycle($data);
        }else{
            $array=$data;
        }
        $Edit=new  FreightTemplatequrey();
        $Edit->Edit_data_update($fid,$name,$type,$sort,$array,$data);
    }
    function template_Data_cycle($data){
        $array = [];
        for ($i = 1; $i <= $data['pid']; $i++) {
            $area_template_id="area_template_id" . $i . "";
            if(array_key_exists($area_template_id,$data)){
                $array[$i - 1] = [
                    $data["area_template_id" . $i . ""],
                    $data["first_value" . $i . ""],
                    $data["first_fee" . $i . ""],
                    $data["follow_value" . $i . ""],
                    $data["follow_fee" . $i . ""],
                    $data["distribution_area" . $i . ""]
                ];
            }
        }
     return $array;
    }
    function data_processings($data)
    {
        $is_array_key=array_key_exists('template', $data);
        if($is_array_key){
            //地区模板存在(新建数据)
            $this->Regional_template_existence($data);
        }else{
            //地区模板不存在(新建数据)
            $this->Templates_do_not_exist($data);
        }
    }
    function Regional_template_existence($data){
        //地区模板存在(新建数据)
        $array_data=new FreightTemplatequrey();
        $array_data->Templates_add($data);
    }
    function Templates_do_not_exist($data){
        //地区模板不存在(新建数据)
        $freight_formwork=[
            'id' => $data['freight_formwork_id'],
            'name' => $data['name'],
            'type' => $data['type'],
            'sort' => $data['sort'],
        ];
        $array_data=new FreightTemplatequrey();
        $array_data->Templates_adds($freight_formwork);
    }
}