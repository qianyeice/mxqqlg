<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13
 * Time: 18:53
 */
namespace qiniuSdk;
use \Qiniu\Auth;
use \Qiniu\Storage\UploadManager;

class qiniuSdk
{
    public function q_upload($filename,$file_tmp)
    {
        include_once '../vendor/Qiniu/autoload.php';
        // 用于签名的公钥和私钥
        $app=config('qiNiuSdk');
        $accessKey=$app['accessKey'];
        $secretKey=$app['secretKey'];
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        // 空间名  https://developer.qiniu.io/kodo/manual/concepts
        $bucket = 'newmxqqlg';
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $filePath= $file_tmp; //图片本地路径

        $key =$filename; //上传图片后名字
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }
}





