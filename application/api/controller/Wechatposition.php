<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/13
 * Time: 18:27
 */

namespace app\api\controller;

use apiController\apiController;
use wxPosition\wxPosition;

class Wechatposition extends apiController
{

    public function position()
    {
        $funname = input('funname');
        $callback = input('callback');
        $a = new wxPosition();
        $signPackage = $a->GetSignPackage("wxdfd709a2cef6667f", "4172d6499ee404fec1212bb9b7d3449b");
//        echo '<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>';
//        echo <<<uu
//       <!--document.write("<script src='http://res.wx.qq.com/open/js/jweixin-1.0.0.js' onload='alert(55)'></script>");-->
//       document.write("<script src='http://res.wx.qq.com/open/js/jweixin-1.0.0.js' onload='alert(1)'></script>")

//  wx.config({
//        debug: true,
//        appId: "{$signPackage["appId"]}",
//        timestamp:"{$signPackage["timestamp"]}",
//        nonceStr:"{$signPackage["nonceStr"]}",
//        signature:"{$signPackage["signature"]}",
//        jsApiList: [
//                'checkJsApi',
//                'onMenuShareTimeline',
//                'onMenuShareAppMessage',
//                'onMenuShareQQ',
//                'onMenuShareWeibo',
//                'onMenuShareQZone',
//                'hideMenuItems',
//                'showMenuItems',
//                'hideAllNonBaseMenuItem',
//                'showAllNonBaseMenuItem',
//                'translateVoice',
//                'startRecord',
//                'stopRecord',
//                'onVoiceRecordEnd',
//                'playVoice',
//                'onVoicePlayEnd',
//                'pauseVoice',
//                'stopVoice',
//                'uploadVoice',
//                'downloadVoice',
//                'chooseImage',
//                'previewImage',
//                'uploadImage',
//                'downloadImage',
//                'getNetworkType',
//                'openLocation',
//                'getLocation',
//                'hideOptionMenu',
//                'showOptionMenu',
//                'closeWindow',
//                'scanQRCode',
//                'chooseWXPay',
//                'openProductSpecificView',
//                'addCard',
//                'chooseCard',
//                'openCard'
//        ]
//     });
//  
//  function tishi(data){
//     if(typeof {$callback} == 'function'){
//         {$callback}(data)
//     }else{
//         alert('没有回调函数')
//     }
//  }
//  wx.ready(function () {
//        if("{$funname}" == 'getLocation'){
//            wx.getLocation({
//              success: function (res) {
//              tishi(res);
//              },
//              cancel: function (res) {
//                tishi(res);
//              }
//        })
//
//      }
//  });
//  wx.error(function(res){
//           alert(JSON.stringify(res));
//  });

//uu;


    }
}