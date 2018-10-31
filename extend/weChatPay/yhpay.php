<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9/009
 * Time: 17:03
 */
namespace weChatPay;
//商家向用户支付
class yhpay{

    public function paytowx($openid,$money,$appid,$mch_id,$key){
        $arr = array();
        $arr['mch_appid'] = $appid;
        $arr['mchid'] = $mch_id;
        $arr['nonce_str'] = md5(rand(10000, 90000));//随机字符串，不长于32位
        $arr['partner_trade_no'] = date("Ymd").rand(10000, 90000) ;//商户订单号
        $arr['openid'] = $openid;
        $arr['check_name'] = 'NO_CHECK';//是否验证用户真实姓名，这里不验证
        $arr['amount'] = $money;//付款金额，单位为分
        $desc = "提现到微信零钱";
        $arr['desc'] = $desc;//描述信息
        $arr['spbill_create_ip'] = '118.126.113.34';//获取服务器的ip
//        $_SERVER['REMOTE_ADDR']
        //封装的关于签名的算法
        ksort($arr);//排序
        //使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串
        $str='';
        foreach($arr as $k=>$v) {
            $str.=$k.'='.$v.'&';
        }
        //拼接API密钥
        $str.='key='.$key;
        $arr['sign']=strtoupper(md5($str));//加密

        $aHeader[]='Content-Type:text/xml;charset=UTF-8';


        $var = $this->arrayToXml($arr);

        $xml = $this->curl_post_ssl('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', $var, 30, $aHeader);
        $data=$this->xmltoarray($xml);
//        dump($data);exit;
        return $data;
    }



    /**
     * @param $url
     * @param $vars
     * @param int $second
     * @param array $aHeader
     * @return bool|mixed
     */
    function curl_post_ssl($url, $vars, $second = 30, $aHeader)
    {
        $isdir =THINK_PATH.'public/';//证书位置
        $ch = curl_init();//初始化curl

        curl_setopt($ch, CURLOPT_TIMEOUT, $second);//设置执行最长秒数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');//证书类型
        curl_setopt($ch, CURLOPT_SSLCERT, $isdir . 'apiclient_cert.pem');//证书位置
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');//CURLOPT_SSLKEY中规定的私钥的加密类型
        curl_setopt($ch, CURLOPT_SSLKEY, $isdir . 'apiclient_key.pem');//证书位置
        curl_setopt($ch, CURLOPT_CAINFO, 'PEM');
        curl_setopt($ch, CURLOPT_CAINFO, $isdir . 'rootca.pem');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);//设置头部
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);//全部数据使用HTTP协议中的"POST"操作来发送

        $data = curl_exec($ch);//执行回话
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }


    //遍历数组方法
    function arraytoxml($data){
        $str='<xml>';
        foreach($data as $k=>$v) {
            $str.='<'.$k.'>'.$v.'</'.$k.'>';
        }
        $str.='</xml>';
        return $str;
    }



    function xmltoarray($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        return $val;
    }

}