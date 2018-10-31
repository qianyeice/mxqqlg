<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\12 0012
 * Time: 15:59
 */
namespace  app\admin\model;
use think\Db;
use think\Model;

class FreightTemplatequrey extends Model {
    /**
     *time:2018.4.15    地区模板编辑相关操作
     *name 白锦国
     */
    function qureys($id){
        $dataarray=Db::table('freight_formwork')->where('id',$id)->select();
        $data=$dataarray;
        if(count($data)>0){
            $datas=Db::table('area_template')->where('fid', $data[0]['id'])->where('is_delete','0')->select();
            if(count($datas)>0){
                $data[0]['area']=$datas;
            }else{
                $data[0]['area']=null;
            }
            return $data;
        }else{
            return lang('no_data');
        }
    }
    function Edit_data_update($fid,$name,$type,$sort,$array,$data){
        $sort_array=Db::table('freight_formwork')->where('id',$fid)->find();
        $sort_arrays=Db::table('freight_formwork')->select();
        $a=0;
        for($i=0;$i<count($sort_arrays);$i++){
//            //排序和原表排序字段相同  或者  排序和原表所有数据排序字段都不同时
           if(($sort==$sort_array['sort'])||($sort!=$sort_arrays[$i]['sort'])){
               $a++;
           }
        }
        if($a>0){
            $this->Edit_data_update_data($fid,$name,$type,$sort,$array,$data);
        }else{
            $this->Jump_return($fid,lang('Existing_sort'));
        }
    }
    function Edit_data_update_data($fid,$name,$type,$sort,$array,$data){
        $is_array=array_key_exists('template',$data);

        //判断有无添加运费模板
        if($is_array){
            //添加运费模板数据
           $template_Data_add= $this->template_Data_add($data["template"],$data["distribution_areatemplate"],$fid);
           if($template_Data_add){
               $this->Jump_return($fid,lang('Regional_template_add_success'));
           }else{
               $this->Jump_return($fid,lang('Regional_template_add_fail'));
           }
        }else{
            //freight_formwork表编辑
            $freight_array=$this->freight_data($fid,$name,$type,$sort);
            //area_template表编辑
            $template_array=$this->template_Data($array,$fid);
            if($freight_array||$template_array){
                //freight_formwork,area_template表编辑成功
                $this->Jump_return($fid,lang('Editor_success'));
            }else if($freight_array==0&&$template_array==0){
                $this->Jump_return($fid,lang('Editor_fail'));
            }else if($freight_array!=0&&$template_array==0){
                //area_template表编辑成功
                $this->Jump_return($fid,lang('Editor_success'));
            }else if($freight_array==0&&$template_array!=0){
                //freight_formwork表编辑成功
                $this->Jump_return($fid,lang('Editor_success'));
            }
        }
    }
    function freight_data($fid,$name,$type,$sort){
//        freight_formwork表编辑
        $data=[
            'name' =>$name,
            'type'=>$type,
            'sort'=>$sort
        ];
        $freight_array=Db::name('freight_formwork')
            ->where('id', $fid)
            ->update($data);
        return $freight_array;
    }
    function template_Data($array,$fid){
//        area_template表编辑
        $add=0;

        /**
         * 吴杰 修改
         * 添加判断模板在没有创建过的情况
         * 2018.5.7
         */
        if(count($array) == count($array, 1) ){
            $data=[
                'first_value' => $array["first_value"],
                'first_fee'=> $array['first_fee'],
                'follow_value'=> $array['follow_value'],
                'follow_fee'=> $array['follow_fee'],
                 'distribution_area'=>$array['distribution_area'],
                'fid'=>$fid
            ];
            $template_array=Db::name('area_template')
                ->insert($data);
            if($template_array!=0){
                $add++;
            }
        }else{
        foreach ($array as $value)
        {
            $data=[
                'first_value' => $value[1],
                'first_fee'=> $value[2],
                'follow_value'=> $value[3],
                'follow_fee'=> $value[4],
            ];

            $template_array=Db::name('area_template')
                ->where('id', $value[0])
                ->update($data);
           if($template_array!=0){
               $add++;
           }
        }
        }
        if($add>0){
            $template_array=$add;
        }else{
            $template_array=0;
        }
        return $template_array;
    }
    function template_Data_add($data,$distribution_area,$fid){
        //添加运费模板数据
        $tr_array=array_keys($data);
        $count_data=count(array_keys($data));
        for($i=0;$i<$count_data;$i++){
            $datas=$tr_array[$i];
            $array=$data[$datas];
            $data_add=[
                'first_value' =>  $array["first_value"] ,
                'first_fee'=>  $array["first_fee"],
                'follow_value'=>  $array["follow_value"] ,
                'follow_fee'=> $array["follow_fee"],
                'distribution_area'=>$distribution_area[$tr_array[$i]],
                'fid'=>$fid
            ];
            $template_array_add=Db::name('area_template')->insert($data_add);
        }

        return $template_array_add;
    }

    /**
     * time:2018.4.16    地区模板添加相关操作
     * name 白锦国
     *
     */
    function Templates_adds($data_array){
        //地区模板不存在(新建数据)
        $a=$this->where_sort($data_array);
        if($a==0){
            $data=[
                'name' =>$data_array['name'],
                'type'=>$data_array['type'],
                'sort'=>$data_array['sort']
            ];
            $freight_array=Db::table('freight_formwork')->insert($data);
          if( $freight_array){
              $this->Jump_return('null',lang('add_success'));
            }else{
              $this->Jump_return('null',lang('add_fail'));
          }
        }else{
            $this->Jump_return('null',lang('Existing_sort'));
        }
    }
    function Templates_add($datas){
        //地区模板存在(新建数据)
        $freight_formwork=[
            'id' => $datas['freight_formwork_id'],
            'name' => $datas['name'],
            'type' => $datas['type'],
            'sort' => $datas['sort'],
        ];
        $a=$this->where_sort($freight_formwork);
       if($a==0){

           $this->Templates_add_Handle($datas,$freight_formwork);
       }else{
           $this->Jump_return('null',lang('Existing_sort'));
       }

    }
    function where_sort($data){
        $sort_array=Db::table('freight_formwork')->select();
        $a=0;
        for($i=0;$i<count($sort_array);$i++){
            //排序和原表排序字段相同
            if(($data['sort']==$sort_array[$i]['sort'])){
                $a++;
            }
        }
        return $a;
    }
    function Templates_add_Handle($datas,$freight_formwork){
        $template = $datas['template'];
        $areatemplate=$datas['distribution_areatemplate'];
        $array_key=array_keys($template);
        $dss=[
            'name' =>$freight_formwork['name'],
            'type'=>$freight_formwork['type'],
            'sort'=>$freight_formwork['sort']
        ];
        $freight_array=Db::table('freight_formwork')->insert($dss);
        if($freight_array){
            $Reply_Id = Db::name('freight_formwork')->getLastInsID();
            $add_shu=0;
            for($i=0;$i<count($array_key);$i++){
                //模板费用随机数组["template"]的下标
                $subscript=$array_key[$i];
                $template[$subscript]['distribution_areatemplate']=$areatemplate[$subscript];
                $area_template=$template[$array_key[$i]];
                $data = [
                    'first_value' => $area_template['first_value'],
                    'first_fee' => $area_template['first_fee'],
                    'follow_value' => $area_template['follow_value'],
                    'follow_fee' => $area_template['follow_fee'],
                    'distribution_area' => $area_template['distribution_areatemplate'],
                    'fid' => $Reply_Id
                ];
                $Reply=Db::table('area_template')->insert($data);
                if($Reply){
                    $add_shu++;
                }
            }
            if($add_shu==count($array_key)){
                $this->Jump_return('null',lang('add_success'));
            }else{
                $this->Jump_return('null',lang('add_fail'));
            }
        }else{
            $this->Jump_return('null',lang('add_fail'));
        }
    }

    /**
     * time:2018.4.16    操作提示和跳转
     * name 白锦国
     *  $this->Jump_return($fid,lang('Regional_template_add_fail'));
     */
    function Jump_return($fid,$lang){
        echo '<script type="text/javascript">alert("'.$lang.'");window.location.href="?s=admin/freight_template_add/index?id='.$fid.'"</script>';
    }

    /**
     * name:白锦国   地区模板删除
     * time：2018 4 17
     * @param $id：当前选中id
     */
    function delete_FreightTemplate($id){
        $data=Db::name('area_template')
            ->where('id', $id)
            ->update(['is_delete' => '1']);
        $array=[];
        if ($data){
            $array=[
                'type' => '1',
                'lang'=>lang('Delete_success')
            ];
        }else{
            $array=[
                'type' => '0',
                'lang'=>lang('Delete_failure')
            ];
        }
        return $array;
    }

}