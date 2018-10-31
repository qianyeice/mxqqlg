<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 17:34
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Spec extends Model
{
    function read()
    {
        $sub = $this->order('id', 'desc')->select();
        //判定是否有数据
        if(count($sub)>0){
            return $sub;
        }else{
            return false;
        }
    }

    /*
     * 规格查询
     * Tankuangkuangguigui.php 查询
     */
    function sel($id)
    {
        $sql = $this->where('id',$id)->find();
//        $addas = $this->isUpdate(true)
//            ->save(['id' => $id, 'name'=>$name,'value'=>$value,'status'=>$status]);
        return $sql;
    }

    /*
     * 添加和修改商品规格
     *Tankuangkuangguigui.php 添加和修改
     */
    function adds($id,$data)
    {
        if(empty($id)){
            $adda = $this->insert($data);
        } else {
            $adda = $this->where('id',$id)
                ->update($data);

        }
        return $adda;
    }

    /*
     * productspecifications删除
     */
    function deleup($id)
    {
        $tcele = $this->where('id',$id)->delete();
        return $tcele;
    }

    /*
     * commoditytypesetting的init查询
     * Tankuangkuangguigui.php的index查询
     */
    function selects()
    {
        $array=array();
        $data = $this->order('id', 'asc')->select();
        foreach ($data as $key=>$val){
            $array[$key]['count']=count(explode(',',$val['value']));
            $array[$key]['id']=$val['id'];
            $array[$key]['name']=$val['name'];
            $array[$key]['value']=$val['value'];
            $array[$key]['status']=$val['status'];
        }
        return $array;
    }

    /*
     * Tankuangkuangguigui.php的spec_ajax
     */
    function spajax($data)
    {
//        $pears = $this->save('name',$data);
//        $pears->id;

        $data = ['name'=>$data];
        $yourid = Db::table('spec')->insertGetId($data);
        return $yourid;
    }

    function spfourajax($fourid,$fourval)
    {
        $data=['value'=>$fourval];
        $ryou = Db::table('spec')->where('id',$fourid)->update($data);
        return $ryou;
    }

    /*
     * Tankuangkuangguigui.php 的生成
     */
    function okbtn_ajax($id,$spec)
    {
        $data=['spec'=>$spec];
        $mail = Db::table('goods_sku')->where('spu_id',$id)->update($data);
        return $mail;
    }
}