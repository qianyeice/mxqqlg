<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/20
 * Time: 18:27
 */
namespace forloop;
class forloop{
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/3/20
     * Time: 18:27
     * @param $data 传入循环页面
     * @return type：array  循环后的数据
     */
    function forloop($data){
        for($i=0;$i<count($data);$i++ ){
            if($data[$i]['pay_method']=='0'){
                $data[$i]['pay_method']=lang('yuepay');
            }elseif ($data[$i]['pay_method']=='1'){
                $data[$i]['pay_method']=lang('wecharpay');
            }
        }
        return $data;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/3/22
     * Time: 14:27
     * @param $data  array 传入需要递归的数组
     * @return type：array  将数据归类后返回
     */
    public  function  gueilei($data){
        $return=array();
        foreach ($data as $b){
            $return[$b['parent_id']][]=$b;
        }
        return $return;
    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * Date: 2018/3/22
     * Time: 14:27
     * @param $data  array 传入需要递归的数组
     * @param $parid  int 传入需要递归的数组的层级
     * @return type：array  将数据归类后返回
     */
    public  function  guei($data, $parid=0){
        if(isset($data[$parid])){
            $d=$data[$parid];
            return $d;
        }
        return false;
    }
}