<?php

namespace app\admin\model;
use think\Db;
use think\Model;

class Coupon_base extends Model
{
    /**
     * time:18-4-18 10.45
     * name:邓剑
     * @param $pink
     * @param $white
     * @param $black
     * @return array
     * 优惠券
     * 没有文件 添加
     */
    public function coupadd($pink, $white, $black)
    {
        switch ($pink[1]) {
            case '3':
                //红包劵
                $array = [
                    'couponfor' => $pink[0],
                    'coupontype' => $pink[1],
                    'couponname' => $white[0],
                    'couponred' => $white[1],
                    'instructions' => $white[2],
                ];
                $data = $this->insert($array);
                return self::coupjudge($data);
                break;
            case '2':
                //现金券
                switch ($pink[2]) {
                    case '1':
                        //现金券固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                        case '2':
                        //领取后固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'effectivelen' => $black[0],
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            case '1':
                //折扣券
                switch ($pink[2]) {
                    case '1':
                        //折扣券固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'effectivelen' => $black[0],
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }
    }

    public static function coupjudge($data)
    {
        $cyan = [];
        if ($data) {
            $cyan = [
                'type' => '1',
                'explain' => '添加成功'
            ];
        } else {
            $cyan = [
                'type' => '0',
                'explain' => '添加失败'
            ];
        }
        return $cyan;
    }

    /**
     * time:18-4-19 16.44
     * name:邓剑
     * 有文件 添加
     */
    public function coupicon($icon,$pink, $white, $black)
    {
        switch ($pink[1]) {
            case '3':
                //红包劵
                $array = [
                    'couponfor' => $pink[0],
                    'coupontype' => $pink[1],
                    'couponname' => $white[0],
                    'couponred' => $white[1],
                    'instructions' => $white[2],
                    'couponicon' => $icon,
                ];
                $data = $this->insert($array);
                return self::coupjudge($data);
                break;
            case '2':
                //现金券
                switch ($pink[2]) {
                    case '1':
                        //现金券固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                            'couponicon' => $icon,
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'effectivelen' => $black[0],
                            'couponicon' => $icon,
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            case '1':
                //折扣券
                switch ($pink[2]) {
                    case '1':
                        //折扣券固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                            'couponicon' => $icon,
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $array = [
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'effectivelen' => $black[0],
                            'couponicon' => $icon,
                        ];
                        $data = $this->insert($array);
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }
    }

    /**
     * 分页数据查询
     * author :陈明福
     * @param $limit 显示数量
     * @param $page 显示页数
     * @return array 数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_coupon($limit, $page)
    {
        $data = $this->field("id,couponname,couponfor,couponicon,coupontype,minprice,maxprice,couponvalue,couponcash,
        couponred,effectivetype,starttime,endtime,effectivelen,instructions,is_display,is_delete")->where("is_delete", "1")
//            ->limit(($page - 1) * $limit, $limit)->select();
            ->page($limit,$page)->select();
//        return $data;
        $array = $this->data_handle($data);
        return $array;
    }

    /**
     * 优惠券总量
     * author :陈明福
     * @return int 数据总量
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function count_coupon()
    {
        $data = $this->field("id")->where("is_delete", "1")
            ->select();
        return count($data->toArray());
    }

    //edit
    public function find_coupon($id)
    {
        $data = $this->field("id,couponname,couponfor,couponicon,coupontype,minprice,maxprice,couponvalue,couponcash,
        couponred,effectivetype,starttime,endtime,effectivelen,instructions,is_display,is_delete")->where("is_delete", "1")->where("id", $id)->select();
        return $data;
    }

    /**
     * 数据处理
     * @param $data 待处理数据组
     * @return array 处理后的数据包
     */
    private function data_handle($data)
    {
        $array = array();
        foreach ($data->toArray() as $k => $v) {
            if ($v["is_display"] == 1) {
                $v["is_display"] = "进行中";
            } else {
                $v["is_display"] = "已结束";
            }
//            $v["time"]=date("Y-m-d ",$v["start_time"])."-".date("Y-m-d ",$v["end_time"]);
            switch ($v["couponfor"]) {
                case 1:
                    $v["couponfor"] = "普通优惠券";
                    break;
                case 2:
                    $v["couponfor"] = "活动优惠券";
                    break;
                case 3:
                    $v["couponfor"] = "新手专区优惠券";
                    break;
                case 4:
                    $v["couponfor"] = "用户分享优惠券";
                    break;
                default:
                    break;
            }
            switch ($v["coupontype"]) {
                case 1:
                    $v["coupontype"] = "折扣卷";
                    $v["time"] = $this->switchs($v);
                    break;
                case 2:
                    $v["coupontype"] = "现金券";
                    $v["time"] = $this->switchs($v);
                    break;
                case 3:
                    $v["coupontype"] = "红包劵";
                    $v["time"] = '无限制-无限制';
                    break;
                default:
                    break;
            }
            $array[$k] = $v;
        }
        return $array;
    }


    private function switchs($v)
    {
        switch ($v["effectivetype"]) {
            case 1:
                $v["time"]=date("Y/m/d ",$v["starttime"])."-".date("Y/m/d ",$v["endtime"]);
                return $v['time'];
                break;
            case 2:
                $v["time"] = '领取后' . $v['effectivelen'] . '天内有效';
                return $v['time'];
                break;
            default:
                break;
        }
    }
    /**
     * time:18-4-19 16.44
     * name:邓剑
     * 编辑
     * 有文件
     */
    public function coupedity($array, $pink, $white, $black, $hiddenid)
    {
        switch ($pink[1]) {
            case '3':
                //红包劵
                $data = $this->where('id', $hiddenid[0])->update([
                    'couponfor' => $pink[0],
                    'coupontype' => $pink[1],
                    'couponname' => $white[0],
                    'couponred' => $white[1],
                    'instructions' => $white[2],
                    'couponicon' => $array,
                    'effectivelen' => null,
                    'endtime' => null,
                    'starttime' => null,
                    'effectivetype' => null,
                    'couponcash' => null,
                    'couponvalue' => null,
                    'maxprice' => null,
                    'minprice' => null,
                ]);
                return self::coupjudge($data);
                break;
            case '2':
                //现金券
                switch ($pink[2]) {
                    case '1':
                        //现金券固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                            'couponicon' => $array,
                            'couponred' => null,
                            'effectivelen' => null,
                            'couponvalue' => null,
                            'maxprice' => null,
                            'minprice' => null,
                        ]);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'effectivelen' => $black[0],
                            'couponicon' => $array,
                            'starttime' => null,
                            'endtime' => null,
                            'couponred' => null,
                            'couponvalue' => null,
                            'maxprice' => null,
                            'minprice' => null,
                        ]);
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            case '1':
                //折扣券
                switch ($pink[2]) {
                    case '1':
                        //折扣券固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                            'couponicon' => $array,
                            'couponcash' => null,
                            'effectivelen' => null,
                            'couponred' => null,
                        ]);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'effectivelen' => $black[0],
                            'couponicon' => $array,
                            'starttime' => null,
                            'endtime' => null,
                            'couponcash' => null,
                            'couponred' => null,
                        ]);///////
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }
    }

    /**
     * time:18-4-19 16.44
     * name:邓剑
     * 编辑
     * 没有文件
     */
    public function coupeditn($pink, $white, $black, $hiddenid)
    {
        switch ($pink[1]) {
            case '3':
                //红包劵
                $data = $this->where('id', $hiddenid[0])->update([
                    'couponfor' => $pink[0],
                    'coupontype' => $pink[1],
                    'couponname' => $white[0],
                    'couponred' => $white[1],
                    'instructions' => $white[2],
                    'couponicon' => null,
                    'effectivelen' => null,
                    'endtime' => null,
                    'starttime' => null,
                    'effectivetype' => null,
                    'couponcash' => null,
                    'couponvalue' => null,
                    'maxprice' => null,
                    'minprice' => null,
                ]);
                return self::coupjudge($data);
                break;
            case '2':
                //现金券
                switch ($pink[2]) {
                    case '1':
                        //现金券固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                            'couponicon' => null,
                            'couponred' => null,
                            'effectivelen' => null,
                            'couponvalue' => null,
                            'maxprice' => null,
                            'minprice' => null,
                        ]);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'couponcash' => $white[1],
                            'instructions' => $white[2],
                            'effectivelen' => $black[0],
                            'couponicon' => null,
                            'starttime' => null,
                            'endtime' => null,
                            'couponred' => null,
                            'couponvalue' => null,
                            'maxprice' => null,
                            'minprice' => null,
                        ]);
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            case '1':
                //折扣券
                switch ($pink[2]) {
                    case '1':
                        //折扣券固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'starttime' => $black[0],
                            'endtime' => $black[1],
                            'couponicon' => null,
                            'couponcash' => null,
                            'effectivelen' => null,
                            'couponred' => null,
                        ]);
                        return self::coupjudge($data);
                        break;
                    case '2':
                        //领取后固定时间
                        $data = $this->where('id', $hiddenid[0])->update([
                            'couponfor' => $pink[0],
                            'coupontype' => $pink[1],
                            'effectivetype' => $pink[2],
                            'couponname' => $white[0],
                            'minprice' => $white[1],
                            'maxprice' => $white[2],
                            'couponvalue' => $white[3],
                            'instructions' => $white[4],
                            'effectivelen' => $black[0],
                            'couponicon' => null,
                            'starttime' => null,
                            'endtime' => null,
                            'couponcash' => null,
                            'couponred' => null,
                        ]);///////
                        return self::coupjudge($data);
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }
    }

    /**
     * 单选删除
     */
    public function coupadelete($id)
    {
       // $data = $this->where('id', $id)->update([
          //  'is_delete' => '0'
       // ]);
        return Db::table('coupon_base')->where('id',$id)->delete();
      //return self::coupjudge($data);
    }
    /**
     * 批量删除
     */
    public function coupalldel($id)
    {
        $data = $this->where('id', '<=', $id[count($id) - 1])->update([
            'is_delete' => '0'
        ]);
        return self::coupjudge($data);
    }
}