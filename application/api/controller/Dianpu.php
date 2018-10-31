<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/22
 * Time: 9:29
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\national;

class Dianpu extends apiController
{
    public function index()
    {
        $add=input('add');
        $data=new national();
        $data=$data->index($add);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
}