<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 15:32
 */
namespace weChatPay;
//用户向商家支付
class Pay {

    /**
     * pay config
     * @var array
     */
    private $_payCfg = array(
        'appId' => '',
        'appSecret' => '',
        'mchId' => '',#商户号
        'mchSecret' => '',#商户号secret
        "notify_url"=>"",#回调地址
    );

    public function __construct($data,$notify_url)
    {
        $this->_payCfg["appId"]=$data["data"]["appID"];
        $this->_payCfg["appSecret"]=$data["data"]["Appsecret"];
        $this->_payCfg["mchId"]=$data["data"]["mch_id"];
        $this->_payCfg["mchSecret"]=$data["data"]["key"];
        $this->_payCfg["notify_url"]=$notify_url;
    }

    /**
     * 下单支付
     * @param $param
     * @return array|string
     */
    public function toPay($param=null)
    {
        $body = empty($param['body']) ? '梦想全球乐购' : $param['body'];//商品描述
        $orderSn = empty($param['orderSn']) ? $this->generateOrderNum() : $param['orderSn'];//商品订单
        $totalFee = empty($param['fee']) ? 0.01 : $param['fee'];//商品加格
        $openId = empty($param['openId']) ? 'ogbUgws3aFCIyJyq1WfdfnDh0lpQ' : $param['openId'];//用户openId
        //统一下单参数构造
        $unifiedOrder = array(
            'appid' => $this->_payCfg['appId'],
            'mch_id' => $this->_payCfg['mchId'],
            'nonce_str' =>$orderSn,
            'body' => $body,
            'out_trade_no' => time().rand(0,100),
            'total_fee' => $totalFee*100,
            'spbill_create_ip' => $this->getClientIp(),
            'notify_url' => $this->_payCfg['notify_url'],//todo 你的支付回调url
            'trade_type' => 'JSAPI',
            'openid' => $openId
        );
        $unifiedOrder['sign'] = $this->makeSign($unifiedOrder,$this->_payCfg["mchSecret"]);
        //请求数据,统一下单
        $xmlData = $this->toXml($unifiedOrder);
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $res = $this->postXmlCurl($url, $xmlData);
        if (!$res) {
            return array('status' => 0, 'msg' => "Can't connect the server");
        }
        $content = $this->toArr($res);
        if (!empty($content) && is_array($content)) {
            if (!empty($content['result_code'])) {
                if ($content['result_code'] == 'FAIL') {
                    return array('status' => 0, 'msg' => $content['err_code'] . ':' . $content['err_code_des']);
                }
            }

            if (!empty($content['return_code'])) {
                if ($content['return_code'] == 'FAIL') {
                    return array('status' => 0, 'msg' => $content['return_msg']);
                }
            }
            $time = time();
            settype($time, "string");
            $resData = array(
                'appId' => strval($content['appid']),
                'nonceStr' => strval($content['nonce_str']),
                'package' => 'prepay_id=' . strval($content['prepay_id']),
                'signType' => 'MD5',
                'timeStamp' => $time
            );
            $resData['paySign'] = $this->makeSign($resData,$this->_payCfg["mchSecret"]);
        }
        return $resData;
    }

    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string
     */
    public function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成签名
     * @param $unifiedOrder
     * @return string
     */
    public function makeSign($unifiedOrder,$key)
    {
        //签名步骤一：按字典序排序参数
        ksort($unifiedOrder);
        $string = $this->toUrlParams($unifiedOrder);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     * @param $unifiedOrder
     * @return string
     * @internal param $unifiedOrder
     */
    public function toUrlParams($unifiedOrder)
    {
        $buff = "";
        foreach ($unifiedOrder as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 输出xml字符
     * @param $unifiedOrder
     * @return string
     */
    public function toXml($unifiedOrder)
    {
        if (!is_array($unifiedOrder) || count($unifiedOrder) <= 0) exit('数组异常');

        $xml = "<xml>";
        foreach ($unifiedOrder as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param $xml
     * @return mixed
     */
    public function toArr($xml)
    {
        //将XML转为array,禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * curl get request
     * @param $url
     * @return array
     */
    public function _curlGetReq($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($res === false) {
            return array('tag' => false, 'msg' => $error);
        }
        return array(
            'tag' => true,
            'msg' => json_decode($res)
        );
    }

    /**
     * 以post方式提交xml到对应的接口url
     * @param $xml
     * @param $url
     * @return mixed
     */
    public function postXmlCurl($url, $xml)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //如果有配置代理这里就设置代理
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }    else    {
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        }
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            exit("curl出错，错误码:$error");
        }
    }

    /**
     * 获取ip
     * @return bool
     */
    public function getClientIp()
    {
        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"]) && '127.0.0.1' != $_SERVER["HTTP_CLIENT_IP"]) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                //echo $ips[$i].'<br>';
                if (!preg_match('/^(10|172\.16|192\.168)\./', $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        //@author jzzmly 2015-8-11 验证从HTTP变量里拿到的ip信息,防止伪造非法字符攻击
        return (empty($ip) || preg_match('/[^0-9^\.]+/', $ip)) ? $_SERVER['REMOTE_ADDR'] : $ip;
        //return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    /**
     * 生成16位订单号
     * @return string
     */
    public static function generateOrderNum()
    {
        return $order_number = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

}




