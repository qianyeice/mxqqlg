<?php

namespace app\admin\controller;

use api\Jssdk;

class Event
{

    /**
     * 关注推送/消息回复
     * name:张平
     */
    public function eventPush()
    {
        $weixin = config('weixin');
        $appid = $weixin['appid'];
        $appsecret = $weixin['appsecret'];
        $wechatObj = new JSSDK($appid, $appsecret);
        if (!isset($_GET['echostr'])) {
           $wechatObj->responseMsg();
        } else {
            $wechatObj->valid();
        }
    }


}