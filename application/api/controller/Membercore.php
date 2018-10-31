<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/24
 * Time: 11:43
 */

namespace app\api\controller;
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:*');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
use apiController\apiController;
use app\api\model\Member;
use app\api\model\Membercenter;
use app\api\model\or_or_sku;
use app\api\model\Member_coupon;
class Membercore extends apiController
{

    /**会员中心总资产，总佣金，总积分，总梦想币，总分红，总余额，VIP等级
     * 程建2018-3-24 14:30
     * @return array 返回会员中心数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function membercore_assets()
    {
        //        接入传入id
        $userId = input("userID");
        if(!is_null($userId)){
            //   实例化Member
            $data = new Member();
            //        引用dmember_assets方法
            $data = $data->member_assets($userId);
            //        调用返回数据
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    /**
     * 用户经验值
     * 易恒辉 6月18日
     */
    public function membercore_jingyan()
    {
        $userId = input("post.userID");
        $data = new Member();
        $val = $data->member_jingyan($userId);
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }

    /*
     * 个人中心现有资产
     * 返回现有资产数据
     * 我的佣金+梦想币+我的分红+余额总数据
     * ID：用户ID
     * 张关燚 2018 3 27 17：12
     * */
    public function existing_assets()
    {
        $id = input('post.userID');
        if(!is_null($id)){
            $data = new Member();
            $data = $data->get_existing_assets($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /*
     * 提现页面默认手机号码*/
    public function mobile()
    {
        $id = input('post.userID');
        if(!is_null($id)){
            $data = new Member();
            $data = $data->get_phone($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /*
     * 可提现金额*/
    public function money()
    {
        $id = input('userID');
        if(!is_null($id)){
            $data = new Member();
            $data = $data->get_money($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /* 陈健英2018-5-8
   * @return  坐席vip
   * @return $val[data][cuont] 军团人数
   * @return $val[data][mxmal][combat] 战斗力
   * @return $val[data][mxmal][mxmal] 梦想值

   */
    public function enti()
    {
        if (!$id = input('post.userID')) {
            return $this->apiReturn($val["type"] = 0, $val["lang"] = 'noUser', null);

        }
        $new = new Member();
        if ($new->laycn($id) && $new->mxmal($id)) {
            $val = array(
                'data' => array(
                    'cuont' => $new->laycn($id),
                    'mxmal' => $new->mxmal($id)
                ),
            );
            $this->apiJournal($val["type"] = 1, $val["lang"] = 'success', $val["data"]);
            return $this->apiReturn($val["type"] = 1, $val["lang"] = 'success',
                $val["data"]);
        } else {
            $this->apiJournal($val["type"] = 0, $val["lang"] = 'noUser', null);
            return $this->apiReturn($val["type"] = 0, $val["lang"] = 'noUser',

                null);
        }

    }

    /* 陈健英2018-5-8
* @return  我的团购订单
 *
*/
    public function mtg()
    {
        $id = input('member_id');
        $sp = input('sp');
        if(!is_null($id)&&!is_null($sp)){
            $new = new or_or_sku();
            $data = $new->mdd($id, $sp);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    public function dreamDay()
    {
        $get = new Member();

        $data = $get->dreamIni();

        return $this->apiReturn($data["type"], $data["lang"], $data["data"]);
    }

    /**
     * 个人中心数据
     * 龙云飞
     * 18-7-17  10:50
     */
    public function memberCenter()
    {
        $userId=input("post.userid");
        $memberdata=new Membercenter();
        $data=$memberdata->getMemberData($userId);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    /**
     * vip等级表相关数据
     *  7月23日 13：56
     */
    public function membercore_dengjiku()
    {
        $data = new Member();
        $val = $data->member_dengjiku();
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }
}