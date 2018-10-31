<?php

namespace wxPosition;

class wxPosition {
    public function GetSignPackage($appId, $appSecret) {
        require_once 'static/wxposition/jssdk.php';
        $jssdk = new \JSSDK($appId, $appSecret);
        $signPackage = $jssdk->GetSignPackage();
        return $signPackage;
    }


}

