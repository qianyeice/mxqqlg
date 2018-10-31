<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/24
 * Time: 10:33
 */

namespace app\api\model;

use phpDocumentor\Reflection\Types\Array_;
use think\Model;
use think\Db;

class Member extends Model
{


    /**
     * 根据用户ID 查询用户可用余额
     * time:18-3-24 10:47;
     * author:陈明福
     * @param $id 用户ID
     * @return array 返回数据查询状态数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function userBalanceInquiry($id)
    {
        $data = $this->field("id,money")->where("id", $id)->find();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'UserInformationError';
        }
        $array["data"] = $data;
        return $array;
    }

    /** 易恒辉
     * 经验值修改
     * 6月19日
     */
    public function member_jingyan($id)
    {
        $data = Db::name('member')->alias('a')->join('member_group b', 'a.group_id=b.id', 'right')
            ->where('a.id', $id)
            ->select();

        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {

            $array["type"] = 0;
            $array["lang"] = 'noData';
        }
        $array["data"] = $data;

        return $array;
    }

    /**
     * 会员中心总资产，总佣金，总积分，总梦想币，总分红，总余额，VIP等级
     * 程建2018-3-24 14:28
     * @param $id 会员id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */


    function member_assets($id)
    {
        $data = $this->field('id,username,is_special,avatar,group_id,dividend,distribution,money,frozen_money,coin,frozen_coin,integral,exp')
            ->where('id', $id)
            ->find();

        //        判定是否有数据
        $array = array();

        if (count($data) > 0) {
            //            计算总资产
            $data->total_assets = $data->dividend + $data->distribution + $data->money + $data->frozen_money + $data->coin + $data->frozen_coin;

            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
        }
        /**
         * name 岳军章
         * time 2018/5/7
         * 改：数据传输方式
         */
        $array["data"] = $data;

        // 5.8   修改
//        $integral='$array["data"]';


        return $array;
    }
    /*
     * 我的现有金额
     * 我的佣金+梦想币+我的分红+账户余额
     * 张关燚 2018 3 27 17：12
     * id:会员id
    */
    //现有金额
    public function get_existing_assets($id)
    {
        $data = $this->field('id,dividend,distribution,money,coin')->where('id', $id)->find();
        $array = array();
        if (count($data) > 0) {
            $data->current_amount = $data->dividend + $data->distribution + $data->money + $data->coin;
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {

            $array["type"] = 0;
            $array["lang"] = 'noData';
        }
        $array["data"] = $data;

        return $array;
    }
    /*
     * 电话号码
     * 张关燚 2018 3 27 17：12
     * id:会员id*/
    //获取电话号码
    public function get_phone($id)
    {
        $data = $this->field('id,mobile')->where('id', $id)->find();
        if (count($data) > 0) {
            $data->phone = $data->mobile;
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
        }
        $array["data"] = $data;

        return $array;
    }

    //可提现金额就是余额
    public function get_money($id)
    {
        $data = $this->field('id,money,openid')->where('id', $id)->find();
        if (count($data) > 0) {
            $data->phone = $data->money;
            $array["type"] = 1;
            $array["lang"] = 'success';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
        }
        $array["data"] = $data;

        return $array;
    }

    /**
     * 50，大转盘的抽奖次数
     * 陈昌海 2018-3-27 16:28
     * @param $id 用户id
     * @return array
     */
    public function draw($id)
    {
        $luck = $this->field('id,username,Sign')->where('id', $id)->find();
        $array = array();
        if (count($luck) > 0) {
            //计算总资产
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $luck;

        } else {
            $array["type"] = 0;
            $array["lang"] = lang('noData');
            $array["data"] = $luck;
        }
        return $array;
    }

    /**
     * 用户 订单 信息查询；
     * time：18-3-29 10:33;
     * author:陈明福
     * @param $id 用户id
     * @param $orderNumber 订单编号
     * @return array 状态数据包
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getUser_details($id, $orderNumber)
    {
        $data = $this->query("call procedure_User_details(" . $id . ",'" . $orderNumber . "')");
        $array = array();
        switch ($data[0][0]["type"]) {
            case 1:
                $array["type"] = 1;
                $array["lang"] = "success";
                $array["data"] = $data[0][0];
                break;
            case 0:
                $array["type"] = 0;
                $array["lang"] = "Error_of_order_information";
                $array["data"] = "";
                break;
            case -1:
                $array["type"] = 0;
                $array["lang"] = "noUser";
                $array["data"] = "";
                break;
        }
        return $array;
    }


    /**
     * app手机号登录和注册一体
     * time：18-5-4 09:48;
     * author:冯云祥
     * @param $phone 手机号
     * @param $message 输入短信
     * @param $rand  生成短信
     * @param $data  发送短信返回参数
     */
    function MobileLogin($phone, $message, $rand,$pid)
    {
        $array=[];
        if ($message != $rand) {
            $array["type"] = 0;
            $array["lang"] = lang('duanxin2');
            $array["data"] = "";
        }else{
            if($pid == 0){
                $parent_id = Db::table('member')->where('Highest',1)->field('id')->find();
                $pid = $parent_id['id'];
            }
            $a = $this->where('mobile', $phone)->select();
            if (count($a) == 0) {
                $data = ['id'=>null,'mobile' => $phone,'parent_id'=>$pid,'register_time'=>time(),'username'=>'梦想全球乐购','avatar'=>'http://thirdwx.qlogo.cn/mmopen/vi_32/HBRpsGH2ND5hobibOvkiby5y9OK1C7kdqPFuZodqBZ1Uv3JqT76K4oLaMfKAdU8RKWXb3Ruz1FdZQub3iaMDibAVxA/132',];
                $b = Db::table('member')->insert($data);
                if ($b){
                    $c = $this->where('mobile', $phone)->select();
                    if (count($c)!=0){
                        $array["type"] = 1;
                        $array["lang"] = lang('success');
                        $array["data"] = $c[0]['id'];
                    }else{
                        $array["type"] = 0;
                        $array["lang"] = lang('dlshibai');
                        $array["data"] = "";
                    }
                }else{
                    $array["type"] = 0;
                    $array["lang"] = lang('dlshibai');
                    $array["data"] = "";
                }
        } else{
                $array["type"] = 1;
                $array["lang"] = lang('success');
                $array["data"] = $a[0]['id'];

            }

        }

        return $array;

    }

    /**
     * app注册用户
     * time：18-5-4 09:48;
     * author:冯云祥
     * @param $phone 手机号
     * @param $message 输入短信
     * @param $rand  生成短信
     * @param $data  发送短信返回参数
     */
    function register($phone, $message, $rand)
    {
        $a = $this->where('mobile', $phone)->select();
        $array = [];
        if ($message == $rand) {
            if (count($a) == 0) {
                $data = ['mobile' => $phone];
                $b = $this->insert($data);
                if ($b) {
                    $userId = $this->getLastInsID();
                    $array["type"] = 1;
                    $array["lang"] = lang('zccg');
                    $array["data"] = $userId;
                } else {
                    $array["type"] = 0;
                    $array["lang"] = lang('faileds');
                    $array["data"] = $b;
                }
            } else {
                $array["type"] = 0;
                $array["lang"] = lang('xxxxx');
                $array["data"] = $a;
            }
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('duanxin2');
            $array["data"] = $a;
        }
        return $array;
    }

    /**
     * 获取用户openid
     * author:冯云祥
     * @param $mid 用户id
     */
    public function member_openid($mid)
    {
        $data = $this->field('openid')->where('id', $mid)->find();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang('success');
            $array["data"] = $data->toArray();
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('faileds');
            $array["data"] = $data;
        }
        return $array;
    }

    /*
 * 陈健英
 * 坐席vip  军团人数
 * */
    public function laycn($id)
    {
        if ($id == 1) {
            $count = $this->count();
            return $count;
        }

        $count = 0;
        while (true) {
            $data = $this->where('parent_id in (' . $id . ')')->field('id')->select();
            $num = count($data);
            if ($num > 0) {
                $count += $num;
                $ids = array();
                foreach ($data as $k => $v) {
                    $ids[] = $v['id'];

                }
                $id = implode(',', $ids);
            } else {
                break;
            }
        }

        return $count;
    }

    /*
 * 陈健英
   * 梦想值 =分成金额      $mxmal
 * */
    public function mxmal($id)
    {
        $com = 0;
        $da = $this->where('id', $id)->field('mxmal')->select();
        $data['mxmal'] = $da[0]['mxmal'];
        $combat = $this->query('call combat(' . $id . ')');
        foreach ($combat[0] as $mun) {
            $com += $mun['paid_amount'];
        }
        $data['combat'] = $com;
        return $data;
    }

    /**
     * 获取帮助完成任务的人的信息
     * @param $id array
     * 张帅
     */
    public function get_msg($id)
    {
        $arr = array();
        if (count($id) > 0) {
            for ($i = 0; $i < count($id); $i++) {
                $data = Db::name('member')
                    ->field('username,avatar')
                    ->where('id', $id[$i])
                    ->select();

                $arr[$i] = $data[0];
            }
            return array(
                'type' => 1,
                'data' => $arr,
                'lang' => "success"
            );
        } else {
            return array(
                'type' => 0,
                'data' => $arr,
                'lang' => "error"
            );
        }

    }

//   public function cir($id){
//       if( is_numeric($id)==true && $id.length>=10 ){
//
//       }
//    $data=$this->where('id',$id)->select();
//    if(count($data)>0){
//        $array["type"]=1;
//        $array["lang"]=lang('success');
//    }else{
//        $array["type"]=0;
//        $array["lang"]=lang('noData');
//    }
//    $array["data"]=$data->toArray();
//    return $array;
//}

    /**
     * 易婷婷
     * 手机绑定
     */
    public function bangd($phone, $img, $openid, $nickname,$pid)
    {
        $val = Db::table("member")->where('mobile', $phone)->find();
        if (!empty($val)) {
            if ($val["openid"] == null||$val["openid"] != $openid) {
                $data = Db::table("member")->where('mobile', $phone)->update([
                    'openid'=>$openid,
                    'username'=>$nickname,
                    'avatar'=>$img
                ]);
            }else{
                $data =null;
            }
        } else {
            if($pid == 0){
                $Highest = Db::table("member")->where('Highest',1)->value('id');
                $data = Db::table("member")->insert(array('mobile' => $phone, 'avatar' => $img, 'openid' => $openid, 'username' => $nickname,'parent_id'=> $Highest));
            }else{
                $data = Db::table("member")->insert(array('mobile' => $phone, 'avatar' => $img, 'openid' => $openid, 'username' => $nickname,'parent_id'=> $pid));
            }
        }
        $array = array();
        if (!isset($data)) {
            $array["type"] = 0;
            $array["lang"] = $openid;
            $array["data"] = $val["openid"];
        } else {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = "绑定成功";
        }
        return $array ;
    }

    /**
     * 现金红包领取奖金接口
     * @param $id
     * @param $money
     */
    public function savered($id)
    {
//        $money=intval ($money);

        $con = Db::table('paison')->where('member_id', $id)->update(['progress' => 1]);
        $data = $this->where('id', $id)->setInc('money', 36);
        if ($data > 0) {
            return array(
                'type' => 1,
                'data' => 'tru',
                'lang' => '成功'
            );
        } else {
            return array(
                'type' => 0,
                'data' => 'false',
                'lang' => '成功失败'
            );
        }
    }

//return array(
//'type' => 1,
//'data' => $arr,
//'lang' => "success"
//);
//} else {
//    return array(
//        'type' => 0,
//        'data' => $arr,
//        'lang' => "error"
//    );
//}

    public function dreamIni()
    {
        $all = Db::name("site_dream")->where("id", 1)->field("dream,buyordinary,buybulk")->select();

        $arr = array();
        if ($all) {
            $arr['type'] = 1;
            $arr['data'] = $all[0];
            $arr['lang'] = 'success';
        } else {
            $arr['type'] = 0;
            $arr['data'] = "";
            $arr['lang'] = 'error';
        }

        return $arr;
    }


    public function getOpenid($member_id){
        $openid=$this
            ->field("openid")
            ->where("id",$member_id)
            ->find();
        return $openid;
    }


    public function getParentid($member_id){
        $id=$this->field("parent_id")
            ->where("id",$member_id)
            ->find();
        return $id;
    }


    public function quesu($member_id,$parent_id){
        $res=$this->query('call insert_order('.$member_id.','.$parent_id.')');
        return $res;
    }

    /**
     *  vip等级表相关数据
     *  7月23日 13：56
     */
    public function member_dengjiku(){
        $data = Db::name('member_group')->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data;
        } else {

            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = null;
        }



        return $array;

    }

}