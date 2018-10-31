<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/12
 * Time: 10:38
 */

namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Lottery_prize;
use think\Db;
use qiniuSdk\qiniuSdk;


class LotteryPrizeEdit extends adminController
{
    /**
     * 奖品配置编辑
     * @param
     * @return
     * name: 岳军章
     * time:2018 04 12 9:25
     */
    public function edit()
    {
        //获取验证器
        $validate = new \app\admin\validate\Lottery_prize;
        //实例化模型
        $moder = new Lottery_prize();
        //获取数据
        $id = input('get.id');

        $data['lottery_id'] = input('get.lottery_id');
        $data['type'] = input('post.type');
        $data['name'] = input('post.name');
        $data['probability'] = input('post.probability');
        $data['number'] = input('post.number');
        $data['is_examine'] = input('post.is_examine');
        $data['remarks'] = input('post.remarks');
        //查询
        $lists = $moder->prize_find($id);
        $this->assign('lists',$lists);

        $array = [];
        //数据验证
        if (!$validate->check($data)) {
            $array['lang'] = $validate->getError();
            //验证传参
            $this->assign('array',$array);

            return view();
        } else {
            //接收添加/修改数据
            if($_FILES['site_logo']['tmp_name']!=""){
                $file_tmp=$_FILES['site_logo']['tmp_name'];
                $qiniu=new qiniuSdk();
                $name=md5($_FILES['site_logo']['name'].time());
                $dat=$qiniu->q_upload($name,$file_tmp);
                $logo='http://p5od7vvyw.bkt.clouddn.com/'.$dat['key'];
                $data['img']=$logo;
            }
            $sql = $moder->prize_edit($id,$data);
            if ($sql) {
                //跳转页面
                echo '<script>alert("编辑成功！");location.href="javascript:history.go(-2)"</script>';

            } else {
                $this->error('失败');
            }
        }

    }

}