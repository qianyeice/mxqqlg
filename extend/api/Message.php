<?php
namespace  api;
use https\curl;
use think\Db;
use aliyunShortmessage\api_demo\SmsDemo;
class Message{
    /**
     *
     * @param $type
     * @param $lang
     * @param $data
     * @return mixed
     */
    private function wxreturn($type,$lang,$data){
        $array['type'] = $type;
        $array['lang'] =$lang;
        $array['data'] =$data;
        return $array;
    }//返回参数
    private function wxmessage ($openid,$template_id,$first,$orderMoneySum,$orderProductName,$Remark){
        $data=array(
            "touser"=>$openid,
            "template_id"=>$template_id,
            "url"=>"http://cg.mxqqlg.com",
            "data"=>array(
                "first"=>array(
                    "value"=>$first,
                    "color"=>"#173177"
                ),
                "orderMoneySum"=>array(
                    "value"=>$orderMoneySum,
                    "color"=>"#173177"
                ),
                "orderProductName"=>array(
                    "value"=>$orderProductName,
                    "color"=>"#173177"
                ),
                "Remark"=>array(
                    "value"=>$Remark,
                    "color"=>"#173177"
                ),
            )
        );
        $a=new WxLogin();
        $b=json_decode($a->Send_message($openid,$template_id,$data));
        dump($b);
        exit;
        if($b){
          return  $this->wxreturn(1,$b['lang'],'');
        }else{
            return  $this->wxreturn(0,$b['lang'],'');
        }
    }//微信发送接口
    private function mobilemessage($mobile,$content){
        $data = new SmsDemo();
        $data::sendSms($mobile,$content);
//        $a=new WxLogin();
//        $b=json_decode($a->Send_message($mobile));
//        if($b){
//            return  $this->wxreturn(1,$b['lang'],'');
//        }else{
//            return  $this->wxreturn(0,$b['lang'],'');
//        }
    }//短信发送接口
    private function getOpenidOrMoble($uid){
        $contact= Db::table('member')->where('id',$uid)->field('mobile,openid')->find();
        if(empty($contact['openid'])){
            return array('type'=>'mobile','data'=>$contact['mobile']);
        }else{
            return array('type'=>'openid','data'=>$contact['openid']);
        }
    }//取id

    public function  message($uid,$template,$first,$orderMoneySum,$orderProductName,$Remark){
        $s= $this->getOpenidOrMoble($uid);
        if($s['type']=='openid'){
            $template_id = config('weixinz');
            return $this->wxmessage($s['data'],$template_id['template_id'][$template],$first,$orderMoneySum,$orderProductName,$Remark);
        }else{
            return $this->mobilemessage(13699004480,'木子青');
        }
    }
//    public function getTemplatemessage($uid,$template,$first,$orderMoneySum,$orderProductName,$Remark){//
//      return  $this->message($uid,$template,$first,$orderMoneySum,$orderProductName,$Remark);
//    }




}
