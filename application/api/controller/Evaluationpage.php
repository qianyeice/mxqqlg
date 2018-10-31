<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\22 0022
 * Time: 9:27
 */
namespace app\api\controller;
use apiController\apiController;
use Evaluation_interface_if\Evaluation_interface_if;

Class Evaluationpage extends apiController {
    /*
     * @param $member_id:用户id
     * @param $spu_id:商品id
     * @param $content:用户评价内容
     * @return 返回查询后结果
     * 发表评论接口
     * Time: 2018\3\22  15:20 name：白锦国
     */
    function Evaluation_interface(){
        $member_id=input('post.id');
        $content=input('post.val_title');
        $spu_id=input('post.spu_id');
        $spu_id = explode(',',$spu_id);
        $data=new Evaluation_interface_if();
        return $data->judge($member_id,$content,$spu_id);
    }
}