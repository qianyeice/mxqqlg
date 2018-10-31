<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\7 0007
 * Time: 15:57
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\FreightTemplatequrey;
use Freight_data_processing\Freight_data_processing;

class FreightTemplateAdd extends adminController {
    /**
     * Class SlideSetting
     * @package app\admin\controller 运费模板添加页面
     * name：白锦国
     *time:2018.4.7 16:10
     */
    function index(){
        $id=input('id');
        $data=new FreightTemplatequrey();
        if($id=='null'){
            return view('freight_template_add/init');
        } else{
            $array=$data->qureys($id);
            $this->assign('array',$array);
            if($array[0]['area']==null){
                $array[0]['area'][0]=[
                    "id" => '',
                    "first_value" => '1',
                    "first_fee" => '1',
                    "follow_value" => '1',
                    "follow_fee" => '1',
                    "distribution_area" => lang('Edited_area'),
                    "is_delete" =>'0',
                    "fid" => $id
                ];
            }
            $this->assign('name', $array[0]['area']);
            return view('freight_template_add/index');
        }
    }
    function Add_to(){
        //运费模板编辑
        $data=new Freight_data_processing();
        $data->data_processing($_POST);
        header('Location:?s=admin/freight/index');
    }
    function Add_Add(){
        //运费模板添加
        $data=new Freight_data_processing();
        $data->data_processings($_POST);
        header('Location:?s=admin/freight/index');
    }
    /**
     * name:白锦国   地区模板删除
     * time：2018 4 17
     * @param $id：当前选中id
     */
    function delete_FreightTemplate(){
        $id=input('id');
        $data=new FreightTemplatequrey();
        $array=$data->delete_FreightTemplate($id);
        return $array;
    }
}