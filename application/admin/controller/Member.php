<?php

namespace app\admin\controller;

use adminController\adminController;

//use app\admin\model\Member;

class Member extends adminController
{
    /**
     * 用户管理  列表
     * 吴杰
     * 2018.4.25
     */
    public function lists()
    {
        $mem = new \app\admin\model\Member();
        $start = !is_null(input('page')) ? input('page'): 0;
        $limit = !is_null(input('limit')) ? input('limit') : 10;
        $tables = $mem->index($start, $limit);
        if (isset($_GET['view'])) {
            $hd = input('hd');
            $option = input('option');
            $mem = new \app\admin\model\Member();
            $data = $mem->memquerys($hd, $option, $start, $limit);
            $this->assign("data", $data);
            $this->assign("limit", $limit);
            $this->assign('count', $tables["number"]);
            $this->assign('page', $start);
            $this->assign('end', ceil($tables["number"] / $limit));
            $this->assign('view', false);
            $array = [
                '0' => $hd,
                '1' => $option
            ];
            return $array;
        } else {
            $this->assign("data", $tables["date"]);
            $this->assign("limit", $limit);
            $this->assign('count', $tables["number"]);
            $this->assign('page', $start);
            $this->assign('end', ceil($tables["number"] / $limit));
            $this->assign('view', true);

        }
       return view();
    }

    //编辑
    public function modify()
    {
        $id = $_GET['id'];
        return view()->assign('id', $id);
    }

    //编辑 - 更新
    public function moupdata()
    {
        $cyan = input('cyan/a');
        $pink = input('pink/a');
        $id = input('id');
        $mem = new \app\admin\model\Member();
        return $mem->edit($id, $cyan, $pink);
    }

    //上级
    public function sup()
    {
        $name = $_GET['name'];
        $id = $_GET['id'];
        return view()->assign([
            'name' => $name,
            'id' => $id
        ]);
    }

    //修改上级 - 搜索
    public function upquery()
    {
        $phone = input('mobile');
        $mem = new \app\admin\model\Member();
        return $mem->memquery($phone);
    }

    //修改上级
    public function updata()
    {
        $supid = input('supid');
        $id = input('id');
        $mem = new \app\admin\model\Member();
        return $mem->memsup($supid, $id);
    }

    //查看收货地址
    public function address()
    {
        $id = $_GET['id'];
        $mem = new \app\admin\model\Member_address();
        $inform = $mem->memaddress($id);
        return view()->assign('address', $inform);

    }

    //用户管理  删除
    public function adelete()
    {
        $id = input('id');
        $mem = new \app\admin\model\Member();
        return $mem->memadelete($id);
    }

    //用户管理  pilaing删除
    public function alldelete()
    {
        $ins = input('ins');
        $array = input('array/a');
        $mem = new \app\admin\model\Member();
        return $mem->memalldelete($array, $ins);
    }

    //查询
    public function querys()
    {
        $mem = new \app\admin\model\Member();
        $start = !is_null(input('page')) ? input('page') : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 10;
        $tables = $mem->index($start, $limit);
        $hd = $_GET['hdd'];
        $option = $_GET['opp'];
        $mem = new \app\admin\model\Member();
        $data = $mem->memquerys($hd, $option, $start, $limit);
        $this->assign("data", $data);
        $this->assign("limit", $limit);
        $this->assign('count', $tables["number"]);
        $this->assign('page', $start);
        $this->assign('end', ceil($tables["number"] / $limit));
        $this->assign('hd', $hd);
        $this->assign('option', $option);
        return view();
    }

    /**
     * 用户数据编辑修改
     * 吴杰
     * 2018.4.25
     */
//    public function update()
//    {
//        $data = new \app\admin\model\Member();
//
//        if (input("info.money.action") == "inc") {
//            $update = input("info.money.num");
//            if (input("info.integral.action") == "inc") {
//                $jifen = input("info.integral.num");
//            } else {
//                $jifen = -input("info.integral.num");
//            }
//        } else {
//            $update = -input("info.money.num");
//            if (input("info.integral.action") == "inc") {
//                $jifen = input("info.integral.num");
//            } else {
//                $jifen = -input("info.integral.num");
//            }
//        }
//        $content = input("msg");
//        $id = input("id");
//        $cont = $data->menber($id, $update, $jifen, $content);
//
//    }

}