<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/24
 * Time: 10:36
 */
namespace app\common\validate;
use think\Validate;
class Address extends Validate
{
    /**
    * 验证码
    * @param  mobile 验证字段
    * @param  require number length regex  验证规则
    * 岳军章
    * 2018-3-24 14：00
    */
    //定义验证规则
    protected $rule = [
        'mobile'  => ['require','number', 'length' => 11, 'regex' => '/^1[3|4|5|7|8][0-9]{9}$/'],
        'name'    => ['require'],
        'address' => ['require'],
        'detailed'=> ['require'],
        //搜索关键字正则
        'keyword'=>['require','Keyword_verification'=>"/^\d[-]?\d$/"]
    ];

       //定义提示消息
    protected $message = [
        'mobile.require'  =>  '必须输入电话号码',
        'mobile.number'   =>  '电话号码必须是数字',
        'mobile.regex'    =>  '电话号码输入不正确',
        'name.name'     =>  '必须输入姓名',
        'detailed.detailed' =>  '必须输入详细地址',
        'keyword.require'=>'搜索关键字必须',
        'keyword.Keyword_verification'=>'关键字错误'
    ];

}
