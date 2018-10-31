<?php
namespace weChatPay;
 class weChatPayfun{
     /**
      * 获取用户端实际IP
      * time：18-7-4 21：29
      * 龙云飞
      * @return bool
      */
     public function getIp()
     {

         $ip = false;
         if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
             $ip = $_SERVER['HTTP_CLIENT_IP'];
         }
         if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
             $ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
             if ($ip) {
                 array_unshift($ips, $ip);
                 $ip = FALSE;
             }
             for ($i = 0; $i < count($ips); $i++) {
                 if (!eregi('^(10│172.16│192.168).', $ips[$i])) {
                     $ip = $ips[$i];
                     break;
                 }
             }
         }
         return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
     }

     /**
      * arr转xml
      * 龙云飞
      * 18-7-4 21:38
      * @param $arr
      * @return string
      */
     public function arrayToXml($arr)
     {
         $xml = "<xml>";
         foreach ($arr as $key=>$val)
         {
             if (is_numeric($val)){
                 $xml.="<".$key.">".$val."</".$key.">";
             }else{
                 $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
             }
         }
         $xml.="</xml>";
         return $xml;
     }

     /**
      * 随机字符串
      * 龙云飞
      * 18-7-4  21:50
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
         $string = $string."&key=".$key;
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
                 $buff.= $k . "=" . $v . "&";
             }
         }
         $buff = trim($buff, "&");
         return $buff;
     }

     /**
      * xml转array
      * @param $xml
      * @return mixed
      */
     function xmlToArray($xml)
     {
         //禁止引用外部xml实体
         libxml_disable_entity_loader(true);
         $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
         return $values;
     }
 }