<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 13:40
 */

namespace app\api\model;
use think\Db;
use think\Model;

class Sign extends Model
{
    /**
     * 判断是否是连续签到
     * time:18-3-31 16.15
     * name:陈昌海
     * @param $member_id 用户名
     * @return 返回数据
     */
    public function signList($member_id)
    {
        $sign = $this->where('member_id', $member_id)->find();
        $grade = Db::table('member')->where('id',$member_id)->field("group_id,avatar")->find();//查询用户等级

        $firstday = date("Y-m-01", time());//当前月的第一天
        $today = date("Y-m-d", time());

        if($sign==null){
            $sign = $this->data(['time'  =>  time(), 'member_id' =>  $member_id,'continuous_sign'=>1])->save();

        }

        /**判断时间差，然后处理签到次数*/
        /**昨天的时间戳时间范围*/
        $t = time();
        $last_start_time = mktime(0, 0, 0, date("m", $t), date("d", $t) - 1, date("Y", $t));
        $last_end_time = mktime(23, 59, 59, date("m", $t), date("d", $t) - 1, date("Y", $t));

        $today_start_time =mktime(0,0,0,date("m", $t), date("d", $t), date("Y", $t));
        /** 判断今天是否是本月第一天 */
        if ($firstday == $today && $sign['time']<$today_start_time) {

            $da['time'] = time();

            $da['continuous_sign'] = 1;

            $this->where("member_id", $member_id)->update($da);

        } else {
            /**判断最后一次签到时间是否在昨天的时间范围内*/
            if ($last_start_time < $sign['time'] && $sign['time'] < $last_end_time) {
                $da['time'] = time();
                /*判断是否连续签到30天*/
                if($sign['continuous_sign']==30){
                    $da['continuous_sign']=1;
                }else{
                    $da['continuous_sign'] = $sign['continuous_sign'] + 1;
                }
                /**增加积分、添加连续签到天数操作*/
                $integral = $this->integral($grade["group_id"],$da['continuous_sign']);
                $integral= intval($integral);
                DB::table("member")->where("id",$member_id)->setInc("integral",$integral);//增加相应积分
                DB::table("member")->where("id",$member_id)->setInc("Sign",1);//增加相应转盘次数
                $insert=["time"=>time(),"get"=>"签到","number"=>$integral,"member_id"=>$member_id,"img"=>$grade["avatar"],"spec"=>"签到获得积分"];
                DB::table("get_integral")->where("id",$member_id)->insert($insert);
                $this->where("member_id", $member_id)->update($da);//增加连续签到天数
            } else {
                /**返回已经签到的操作*/
                $da['time'] = time();
                $da['continuous_sign'] = 1;
                /*判断是否是昨天之前签到*/
                if ($sign['time'] < $last_start_time) {
                    $integral = $this->integral($grade["group_id"],$da['continuous_sign']);
                    $integral= intval($integral);
                    DB::table("member")->where("id",$member_id)->setInc("integral",$integral);//增加相应积分
                    $insert=["time"=>time(),"get"=>"签到","number"=>$integral,"member_id"=>$member_id,"img"=>$grade["avatar"],"spec"=>"签到获得积分"];
                    DB::table("get_integral")->where("id",$member_id)->insert($insert);
                    $this->where("member_id", $member_id)->update($da);
                }
            }
        }
    }
        /**
         * 查询连续签到天数
         * time:18-3-31 16.15
         * name:陈昌海
         * @param $member_id 用户名
         * @return  返回的数据
         */
        public function continuous($member_id)
        {
            $continuous=$this->where('member_id',$member_id)->find();

            $array=array();

//        判定是否有数据
            if($continuous!=null){
//            计算今日总分红
                $array["type"]=1;
                $array["lang"]='success';
            }else{
                $array["type"]=0;
                $array["lang"]='noData';
            }
            $array["data"]=$continuous;

            return $array;
        }

        /**
         * 增加积分操作
         * time:18-5-24 16.35
         * name:胡波
         * @param $member_id 用户id
         * @param $grade 用户等级
         * @param $continuous_sign 连续签到天数
         */

        public function integral($grade,$continuous_sign){
            $integral=0;
            /*获得不同等级不同签到天数应加的积分*/
            if($grade=="0"||$grade=="1"||$grade=="2"){
                switch ($continuous_sign){
                    case 5: $integral = 60;
                        break;
                    case 10:$integral = 70;
                        break;
                    case 20: $integral = 80;
                        break;
                    case 30: $integral = 90;
                        break;
                    default: $integral = 10;
                        break;
                }
            }else{
                if($grade=="3"){
                    switch ($continuous_sign){
                        case 5: $integral = 250;
                            break;
                        case 10:$integral = 300;
                            break;
                        case 20: $integral = 350;
                            break;
                        case 30: $integral = 900;
                            break;
                        default: $integral = 10;
                            break;
                    }
                }else{
                    if($grade=="4"){
                        switch ($continuous_sign){
                            case 5: $integral = 300;
                                break;
                            case 10:$integral = 400;
                                break;
                            case 20: $integral = 500;
                                break;
                            case 30: $integral = 1600;
                                break;
                            default: $integral = 100;
                                break;
                        }
                    }else{
                        if($grade=="5"){
                            switch ($continuous_sign){
                                case 5: $integral = 3000;
                                    break;
                                case 10:$integral = 4000;
                                    break;
                                case 20: $integral = 5000;
                                    break;
                                case 30: $integral = 16000;
                                    break;
                                default: $integral = 1000;
                                    break;
                            }
                        }
                    }
                }
            }
            return $integral;

        }


    /**
     * 查询签到弹出层信息
     *  time:18-5-25 10.35
     * name:胡波
     * @param $member_id 用户id
     */
    public function signSuccess($member_id){
        $data = array();
        $grade = Db::table('member')->where('id',$member_id)->field("group_id")->find();//查询用户等级
        $sign = $this->where('member_id', $member_id)->field("continuous_sign")->find();

        $integral = $this->integral($grade["group_id"],$sign["continuous_sign"]);

        $data["data"]["grade"] = $grade["group_id"];
        $data["data"]["continuous_sign"] = $sign["continuous_sign"];
        $data["data"]["integral"] = $integral;
        if($sign!=null){
            $data["type"]=1;
            $data["lang"]='success';
        }else{
            $data["type"]=0;
            $data["lang"]='noData';
        }
        return $data;
    }


}