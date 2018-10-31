<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 11:14
 */
namespace app\api\controller;
use apiController\apiController;
use qrcode\qrcode as Qq;

    class Qrcodeadd extends apiController{
    /**
     * 二维码生成
     * 程建 2018-3-28 19：:20
     */
        function get_qr(){
        $url=input('url'); //二维码内容
        if(!is_null($url)){
            $errorCorrectionLevel = 'L';    //容错级别
            $matrixPointSize = 5;           //生成图片大小
            Qq::png($url,false,$errorCorrectionLevel, $matrixPointSize, 2);
            exit;
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}
