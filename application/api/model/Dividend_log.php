<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/3/31
 * Time: 15:01
 */

namespace app\api\model;

use think\Model;

class Dividend_log extends Model
{
    /**
     * 用户分红日志
     * 李磊 2018-3-29 15:10
     * @param $id 用户id
     * @return array 返回每天分红明细
     */
    public function dividendlog($id)
    {
//        $data=$this->field('money')
//            ->where('member_id',$id)
//            ->where('time','>',config('start_time'))
//            ->where('time','<',config('end_time'))
//            ->sum('money');
//        $array=array();
//        //        判定是否有数据
//        if(count($data)>0){
////            计算今日总佣金
//            $array["type"]=1;
//            $array["lang"]='success';
//        }else{
//            $array["type"]=0;
//            $array["lang"]='noData';
//        }
//        $array["data"]=$data;
//        return $array;

        //冯云祥
        $data = $this->where('member_id', $id)->order('time', 'desc')->select();
        $ooo = array();
        if(count($data)>0){
            foreach ($data as $key => $v) {
                $time = $v['time'];
                $month = preg_replace("/[^\-]*\-([^\-]*)\-.*/", "$1", $time);   // 月
                $yaer = preg_replace("/[w]{0,4}\-.*/", "$1", $time);     //年
                $zhueh = $yaer . '年' . $month . '月';
                if(isset($ooo[$zhueh]))
                {
                    $ooo[$zhueh]['data'][]=$v ;
                }else{
                    $ooo[$zhueh]['month']=$zhueh;
                    $ooo[$zhueh]['data']=array($v);
                }
            }
            $kk=array();
            foreach ($ooo as $v){
                $kk[]=$v;
            }
            unset($ooo);
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$kk;
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]='';
        }
        return $array;
    }
}
