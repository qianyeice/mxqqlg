<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/13
 * Time: 17:24
 */

namespace app\api\model;

use think\Model;
use https\curl;

class Getpositiondata extends Model
{
    public function positionData()
    {
        $curl = new curl();
    }
}