<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Lottery;
use  think\facade\Request;
use qiniuSdk\qiniuSdk;


/**
 * 抽奖编辑
 * name:张平
 * time:2018 03 29 14:25
 * Class Luckdrowlist
 * @package app\admin\controller
 *
 * 岳军章 2018/4/4 14:00
 *
 */
class Luckdrowlist extends adminController
{
    /**
     * 抽奖活动添加、修改
     * @param  $validate 获取验证器  $model 实例化模型  $array
     * @param $id/$data 获取input值
     * @param  $sql 接收添加/修改数据
     * @return
     * name 岳军章
     * time  2018-04-8 10:46
     *
    */
    public function index()
    {
        //获取验证器
        $validate = new \app\admin\validate\Lottery;
        //实例化模型
        $model = new Lottery();

        $id = input('get.id');

        //接收查询数据
        $lists = $model->lottery_find($id);
        $this->assign('lists',$lists);
        //获取input 值
        $data['name'] = input('post.name');
        $data['start_time'] = input('post.start_time');
        $data['end_time'] = input('post.end_time');
        $data['frequeny'] = input('post.frequeny');
        $data['is_display'] = input('post.is_display');
        $data['content'] = input('post.content');
        $data['explain'] = input('post.explain');
        $data['date'] = date('Y-m-d H:i:s');

        //定义数组
        $array=array();
        //数据验证
        if (!$validate->check($data)) {
            $array['lang'] = $validate->getError();
            //验证传参
            $this->assign('data',$array);
            return view();
        } else {
            //接收添加/修改数据
            //图片临时路径
           if($_FILES['site_logo']['tmp_name']!=""){
               $file_tmp=$_FILES['site_logo']['tmp_name'];
               $qiniu=new qiniuSdk();
               $name=md5($_FILES['site_logo']['name'].time());
               $dat=$qiniu->q_upload($name,$file_tmp);
               $logo='http://p5od7vvyw.bkt.clouddn.com/'.$dat['key'];
               $data['img']=$logo;
           }
            $sql = $model->add_modify($id,$data);
            if ($sql>0) {
                echo '<script>alert("编辑成功！");location.href="javascript:history.go(-2)"</script>';
            } else {
                $this->error('失败');
            }
        }
    }


}