<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/21
 * Time: 16:21
 */
namespace app\admin\validate;
use think\Validate;

class Sekill extends Validate
{
    protected $rule = [
        'name' =>'require',
        'date'=>'require|dateFormat:y-m-d',
        'spu_price'=>'require|min:1|float',
    ];




}