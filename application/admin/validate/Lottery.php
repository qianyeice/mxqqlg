<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/24
 * Time: 10:36
 */
namespace app\admin\validate;
use think\Validate;
class Lottery extends Validate
{
    /**
    * 抽奖活动验证码
    * @param  mobile 验证字段
    * @param  require number length regex  验证规则
    * 岳军章
    * 2018-4-8 15:50
    */
    //定义验证规则
    protected $rule = [
        'name' =>'require',
        'start_time'=>'require|date',
        'end_time'=>'require|date',
        'frequeny'=>'require|number|max:5',
        'is_display'=>'require'

    ];

       //定义提示消息
    protected $message = [
        'name.require'        =>  '必须输入名称',
        'start_time.require'  =>  '请选择开始时间',
        'start_time.date' =>  '开始时间格式不正确',
        'end_time.require'    =>  '请选择结束时间',
        'end_time.date'   =>  '结束时间格式不正确',
        'frequeny.require'    =>  '请输入输入抽奖次数',
        'frequeny.number'     =>  '请输入数字',
        'frequeny.max'        =>  '抽奖次数不能超过5次'
    ];

}
