<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/13
 * Time: 10:53
 */

namespace app\admin\validate;
use think\Validate;

class Lottery_prize extends Validate
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
        'name'       => 'require',
        'probability'=> 'require|float|gt:0|lt:100',
        'number'     => 'require|number',
    ];

    //定义提示消息
    protected $message = [
        'name.require'        =>  '请输入名称',
        'probability.require' =>  '请输入中奖概率',
        'probability.float'   =>  '请输入浮点数字',
        'probability.gt'      =>  '请输入大于0的浮点数字',
        'probability.lt'      =>  '请输入小于100的浮点数字',
        'number.require'      =>  '请输入奖项数值',
        'number.number'       =>  '输入格式不正确',
    ];


}