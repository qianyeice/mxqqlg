<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/24
 * Time: 14:34
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Member_bank;

class Bankcard extends apiController
{
    /**
     * 银行卡页面所有银行卡接口
     * 杜世豪
     * @return  array 该用户绑定的所有银行卡
     * 18.03.24 15:20
     */
    function Showall()
    {
        $id = input('mid');
        if (!is_null($id)) {
            $bank = new Member_bank();
            $data = $bank->showall($id);
//            $type = 0;
////            $data? $type = 1 : $type = 0;
            $this->apiJournal($data["type"], $data["lang"], $data["data"]);//日志
            return $this->apiReturn($data["type"], $data["lang"], $data["data"]);//返回格式
        } else {
            return $this->apiReturn(0, lang('faileds'));//返回格式
        }
    }

    /**
     * 添加银行卡接口
     * 杜世豪
     * @return  array 添加银行卡成功与否的数据
     * 18.03.24 15:20  改于18.7.25
     *
     */
    function Addbankcard()
    {
        $uid = input('uid');
        $name = input('name');
        $code = input('code');
        $phone = input('phone');
        $bank_number = input('bank_number');
        $yzm = cache(md5($phone));

        if(!empty($uid) && !empty($name) && !empty($code) && !empty($phone) && !empty($bank_number)){
            $bank = new Member_bank();
            $data = $bank->Addbankcard($uid,$name,md5($code),$bank_number,$yzm);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 编辑银行卡接口
     * 杜世豪
     * @return  array 编辑银行卡成功与否的数据
     * 18.03.24 15:20
     */
    function Editbankcard()
    {
        $bank = new Member_bank();
        $data = $bank->Editbankcard(input('id'), input('name'), input('bank_name'), input('bank_no'));
        $type = 0;
        $data ? $type = 1 : $type = 0;
        return $this->apiReturn($type, lang('Upload_failure'), $data);
    }

    /**
     * 设置银行卡默认接口
     * 杜世豪
     * @return  array 编辑银行卡成功与否的数据
     * 18.03.24 15:20
     */
    function Setdefault()
    {
        $bank = new Member_bank();
        $data = $bank->Setdefault(input('id'), input('mid'));
        if (input('id') == '' || input('mid') == '') {
            var_dump('格式错误，请重试');
        } else {
            $type = 0;
            $data ? $type = 1 : $type = 0;
            return $this->apiReturn($type, lang('Upload_failure'), $data);
        }
    }

    /**
     * 删除银行卡接口
     * 杜世豪
     * @return  array 删除银行卡成功与否的数据
     * 18.03.24 15:20
     */
    function Deletedefault()
    {
        $bank = new Member_bank();
        $data = $bank->Deletedefault(input('id'));
        $type = 0;
        $data ? $type = 1 : $type = 0;
        return $this->apiReturn($type, lang('delete_faileds'), $data);
    }

    /**
     * 龙云飞
     * wx添加银行卡到数据库
     * @return array
     */

    public function BankcardAdd()
    {
        $uid=input("post.mid");
        $bank_no=input("post.bank_no");
        $bank_name=input("post.bank_name");
        $name=input("post.name");
        $bank_id=input("post.bank_id");
        $bank=new Member_bank();
        if(!is_null($uid)||!is_null($bank_no)||!is_null($bank_name)||!is_null($name)||!is_null($bank_id)){
            $data=$bank->BankCardAdd($uid, $name, $bank_name, $bank_no,$bank_id);
//            dump($data);exit;
            $data ? $type = 1 : $type = 0;
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang("参数错误"),"");
        }



    }


}