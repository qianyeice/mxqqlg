<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/4/24
 * Time: 16:15
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Member extends Model
{
    /**
     * 用户列表
     * Time: 2018\4\23  11:20
     * name：吴杰
     */
    public function index($start, $limit)
    {
        $data["number"] = $this->where('is_delete', '0')->count("id");
        $data["date"] = $this->page($start, $limit)->where('is_delete', '0')->select();
        for ($i = 0; $i < count($data["date"]); $i++) {
            $data["date"][$i]['sup'] = $this->where('id', $data["date"][$i]['parent_id'])->find();
            $data["date"][$i]['login_time'] = date("Y-m-d H:i:s", $data["date"][$i]['login_time']);
            $data["date"][$i]['register_time'] = date("Y-m-d H:i:s", $data["date"][$i]['register_time']);
        }
//        return $data['date']=$this->forfor($data["date"]);

        return $data;
    }

    /**
     * 用户数据修改（余额、积分、修改原因）
     * 吴杰
     * 2018.4.25
     */
//    public function menber($id, $update, $jifen, $content)
//    {
//        $con = $this
//            ->field('money,integral')
//            ->where("id", $id)
//            ->select();
//        $update = $con[0]["money"] + $update;
//        $jifen = $con[0]["integral"] + $jifen;
//        if ($update < 0 || $jifen < 0) {
//            return "false";
//        } else {
//            $data = $this
//                ->where('id', $id)
//                ->update(['money' => $update, 'integral' => $jifen]);
//            if ($data == 0) {
//                return "cuowu";
//            } else {
//                return "true";
//            }
//        }
//    }

//    /**
//     * 用户数据
//     */
//   public function memadd(){
//       $data=$this->select();
////       for ($i=0 ; $i<count($data) ; $i++){
////           $data[$i]['sup']=$this->where('id',$data[$i]['parent_id'])->find();
////       }
//       return $data;
//   }
//
    /**
     * 用户上级
     */
    public function memquery($phone)
    {
        return $this->where('mobile', $phone)->find();
    }

    /**
     * 用户上级 更新字段
     */
    public function memsup($supid, $id)
    {
        $data = $this->where('id', $id)->update(['parent_id' => $supid]);
        return $this->pass($data);

    }

    //for
    public function forfor($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['sup'] = $this->where('id', $data[$i]['parent_id'])->find();
            $data[$i]['login_time'] = date("Y-m-d H:i:s", $data[$i]['login_time']);
            $data[$i]['register_time'] = date("Y-m-d H:i:s", $data[$i]['register_time']);
        }
        return $data;
    }

    /**
     * 查询
     */
    public function memquerys($hd, $option, $start, $limit)
    {
        $reg = "/^1[34578]\d{9}$/";
        switch ($hd) {
            case '':
                switch ($option){
                    case '9':
                        $data = $this->page($start, $limit)->where('is_delete', '0')->select();
                        return $this->forfor($data);
                        break;
                    default:
                        $data = $this->page($start, $limit)->where('is_delete', '0')->where('group_id', $option)->select();
                        return $this->forfor($data);
                        break;
                }
                break;
            case !'':
                switch (preg_match($reg, $hd)) {
                    case '1':
                        switch ($option){
                            case '9':
                                $data = $this->page($start, $limit)->where('is_delete', '0')->where('mobile', $hd)->select();
                                return $this->forfor($data);
                                break;
                            default:
                                $data = $this->page($start, $limit)->where('is_delete', '0')->where('group_id', $option)->where('mobile', $hd)->select();
                                return $this->forfor($data);
                                break;
                        }
                        break;
                    case '0':
                        switch ($option){
                            case '9':
                                $data = $this->page($start, $limit)->where('is_delete', '0')->where('username', $hd)->select();
                                return $this->forfor($data);
                                break;
                            default:
                                $data = $this->page($start, $limit)->where('is_delete', '0')->where('group_id', $option)->where('username', $hd)->select();
                                return $this->forfor($data);
                                break;
                        }
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
     * time:18-4-26 17.01
     * name:邓剑
     * 单删除
     */
    public function memadelete($id)
    {
        $data = $this->where('id', $id)->update(['is_delete' => '1']);
        return $this->pass($data);
    }

    /**
     * time:18-4-26 21.07
     * name:邓剑
     * piliang删除
     */
    public function memalldelete($array, $ins)
    {
        $cyan = [];
        switch ($ins) {
            case 'delete':
                for ($i = 0; $i < count($array); $i++) {
                    if ($array[$i] != 'undefined') {
                        $cyan[$i] = $this->where('id', $array[$i])->update(['is_delete' => '1']);
                    }
                }
                break;
            case 'lock.txt':
                for ($i = 0; $i < count($array); $i++) {
                    if ($array[$i] != 'undefined') {
                        $cyan[$i] = $this->where('id', $array[$i])->update(['islock' => '1']);
                    }
                }
                break;
            case 'unlock':
                for ($i = 0; $i < count($array); $i++) {
                    if ($array[$i] != 'undefined') {
                        $cyan[$i] = $this->where('id', $array[$i])->update(['islock' => '0']);
                    }
                }
                break;
            default:
                break;
        }
        return $cyan;
    }

    /**
     * time:18-4-26 17.01
     * name:邓剑
     * 编辑
     */
    public function edit($id, $cyan, $pink)
    {
        $array = [];
        $data = $this->where('id', $id)->find();
        for ($i = 0; $i < count($cyan); $i++) {
            switch ($i) {
                case 0:
                    switch ($cyan[$i]) {
                        // +
                        case 'inc':
                            $array[$i] = $this->where('id', $id)->update(['money' => ($data['money'] + $pink[$i])]);
                            break;
                        // -
                        case 'dec':
                            $array[$i] = $this->where('id', $id)->update(['money' => ($data['money'] - $pink[$i])]);
                            break;
                        default:
                            break;
                    }
                    break;
                case 1:
                    switch ($cyan[$i]) {
                        // +
                        case 'inc':
                            $array[$i] = $this->where('id', $id)->update(['integral' => ($data['integral'] + $pink[$i])]);
                            break;
                        // -
                        case 'dec':
                            $array[$i] = $this->where('id', $id)->update(['integral' => ($data['integral'] - $pink[$i])]);
                            break;
                        default:
                            break;
                    }
                    break;
                default:
                    break;
            }
        }
        if ($array[0] == 1 || $array[1] == 1) {
            return $this->pass(true);
        } else {
            return $this->pass(false);
        }
    }

    public function pass($data)
    {
        $array = [];
        if ($data) {
            $array = [
                'type' => '1',
                'explain' => '更新成功'
            ];
        } else {
            $array = [
                'type' => '0',
                'explain' => '更新失败'
            ];
        }
        return $array;
    }
}