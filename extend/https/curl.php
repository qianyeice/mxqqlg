<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/28
 * Time: 10:36
 */
namespace https;

class curl {

   public static function curl_get_https($url){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }

   public static function curl_post_https($url,$data){ // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据，json格式
    }


    /**
     * 提现curl
     * @param string $param
     * @param $url
     * @param $cert
     * @param $key
     * @return mixed
     */
    function curl($param="",$url) {
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();                   //初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);         //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);          //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);           //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);      // 增加 HTTP Header（头）里的字段
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().config('weixin')['cert_path']); //这个是证书的位置
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().config('weixin')['key_path']); //这个是证书秘钥的位置
        $data = curl_exec($ch);                 //运行curl
        curl_close($ch);
        return $data;
    }
}