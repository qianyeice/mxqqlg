<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 12:50
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Wechat_material;
use qiniuSdk\qiniuSdk;
use think\Db;

class Materialadd extends adminController{
    /**
     *素材添加
     * @return \think\response\View
     */
    public function index(){
            $date=new Wechat_material();
            if (isset($_GET['id'])){
                $id=$_GET['id'];
                $data=$date->edit($id);
                $this->assign([
                    'data'=>$data['0'],
                ]);
//                dump($data['0']);
            }else{
                $data=[
                    'id'=>'',
                    'name'=>'',
                    'type'=>'',
                    'content'=>'',
                    'image_url'=>'',
                    'video_test'=>'',
                    'video_name'=>'',
                    'video_url'=>''
                ];
                $this->assign([
                    'data'=>$data,
                ]);
            }
        return view('index');
    }

    function yibu(){
        $id=input('id');
        $date=new Wechat_material();
        $data=$date->edit($id);
        return $data['0']['news_json'];
    }

//    添加
    public function url(){
        //实例化七牛云
        $qiliu=new qiniuSdk();
        //素材名字
        $title=input('title');
        //1图文消息 2 表示文本消息 3 图片消息 4 视频消息
        $type=input('type');
        //文本消息内容
        $msgtext=input('msgtext');
        //页面的第一个数组
        $jsonone=input('one');
        //取得当前页面的内容
        $json=input('json');
        //视屏标题
        $videotitle=input('videotitle');
        //视屏描述
        $videodesc=input('videodesc');
        //first数组
        $array=json_decode($jsonone,true);
        //全页面数组
        $kong=json_decode($json,true);
        $data=new Wechat_material();
//        dump($two);
        if ($type==1){
            //页面的第一个数组的临时路径
            $fileone=$_FILES['fileone']['tmp_name'];
            //上传七牛云
            $first=$qiliu->q_upload($_FILES['fileone']['name'],$fileone);
            $two=array();
            for ($i=1;$i<count($kong);$i++){
                $two[$i]=$qiliu->q_upload($_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);
                $kong[$i]['file']='http://p5od7vvyw.bkt.clouddn.com/'.$two[$i]['key'];
            }
            $array['file']='http://p5od7vvyw.bkt.clouddn.com/'.$first['key'];
            $data=$data->addone($type,$array,$kong,$title);
            return $data;
        }else if ($type==2){
            $data=$data->addtwo($type,$msgtext,$title);
            return $data;
        }else if($type==3){
            //图片路径
            $imgtext=$_FILES['imgtext'];
            $imgtext=$qiliu->q_upload($imgtext['name'],$imgtext['tmp_name']);
            $logo='http://p5od7vvyw.bkt.clouddn.com/'.$imgtext['key'];
            $data=$data->addthree($title,$type,$logo);
            return $data;
        }else if($type==4){
            //视屏路径
            $videourl=$_FILES['videourl'];
            $videourl=$qiliu->q_upload($videourl['name'],$videourl['tmp_name']);
            $logo='http://p5od7vvyw.bkt.clouddn.com/'.$videourl['key'];
            $data=$data->addfour($type,$logo,$title,$videotitle,$videodesc);
            return $data;
        }
//        $date=$data->add($title,$type,$msgtext,$jsonjson,$imgtext,$videotitle,$videodesc,$videourl);
    }


//修改
    function xiu(){
        //实例化七牛云
        $qiliu=new qiniuSdk();
        //素材名字
        $title=input('title');
        //1图文消息 2 表示文本消息 3 图片消息 4 视频消息
        $type=input('type');
        //文本消息内容
        $msgtext=input('msgtext');
        //页面的第一个数组
        $jsonone=input('one');
        //取得当前页面的内容
        $json=input('json');
        //视屏标题
        $videotitle=input('videotitle');
        //视屏描述
        $videodesc=input('videodesc');
        //first数组
        $array=json_decode($jsonone,true);
        //全页面数组
        $kong=json_decode($json,true);
        $id=input('id');
        $data=new Wechat_material();
        if ($type==1){
            $date=new Wechat_material();
            $arr=input('file/a');
            if (isset($_FILES['fileone']['name'])){
                //页面的第一个数组的临时路径
                $fileone=$_FILES['fileone']['tmp_name'];
                $first=$qiliu->q_upload($_FILES['fileone']['name'],$fileone);
            }else{
                $first=input('fileone');
            }
            $two=array();
            for ($n=1;$n<count($kong);$n++){
                if (!empty($arr[$n])){
                    if (isset($_FILES['file']['name'][$n])){
                        $two[$n]=$qiliu->q_upload($_FILES['file']['name'][$n],$_FILES['file']['tmp_name'][$n]);
                        $kong[$n]['file']='http://p5od7vvyw.bkt.clouddn.com/'.$two[$n]['key'];
                    }else{
                        $kong[$n]['file']=$arr[$n];
                    }
                }else{
                    $kong=[null];
                }
            }
//            //上传七牛云
//            $first=$qiliu->q_upload($_FILES['fileone']['name'],$fileone);
//            $two=array();
//            for ($i=1;$i<count($kong);$i++){
//                $two[$i]=$qiliu->q_upload($_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i]);
//                $kong[$i]['file']='http://p5od7vvyw.bkt.clouddn.com/'.$two[$i]['key'];
//            }
//            $array['file']='http://p5od7vvyw.bkt.clouddn.com/'.$first['key'];
            $data=$data->xiugai($id,$type,$array,$kong,$title);
            return $data;
        }else if ($type==2){
            $data=$data->xiugaitwo($id,$type,$msgtext,$title);
            return $data;
        }else if($type==3){
            if (isset($_FILES['imgtext'])){
                //图片路径
                $imgtext=$_FILES['imgtext'];
                $imgtext=$qiliu->q_upload($imgtext['name'],$imgtext['tmp_name']);
                $logo='http://p5od7vvyw.bkt.clouddn.com/'.$imgtext['key'];
            }else{
                $imgtext=input('imgtext');
                $logo=$imgtext;
            }
//            $imgtext=$qiliu->q_upload($imgtext['name'],$imgtext['tmp_name']);
//            $logo='http://p5od7vvyw.bkt.clouddn.com/'.$imgtext['key'];
            $data=$data->xiugaithree($id,$title,$type,$logo);
            return $data;
        }else if($type==4){
            if (isset($_FILES['videourl'])){
                //视屏路径
                $videourl=$_FILES['videourl'];
                $videourl=$qiliu->q_upload($videourl['name'],$videourl['tmp_name']);
                $logo='http://p5od7vvyw.bkt.clouddn.com/'.$videourl['key'];
            }else{
                $videourl=input('videourl');
                $logo=$videourl;
            }
            $data=$data->xiugaifour($id,$type,$logo,$title,$videotitle,$videodesc);
            return $data;
        }
    }


    
    public function add()
    {
        return Db::table('wechat_material')->where('status',1)->find();
        $con = mysqli_connect("119.27.171.174","newmxqqlg","newmxqqlg",'newmxqqlg');
        if(!$con){
            die('Could not connect: ' . mysqli_error());
        }else{
            $name = isset($_POST['name'])?$_POST['name']:null;
            $title = isset($_POST['title'])?$_POST['title']:null;
            $pic = isset($_POST['pic'])?$_POST['pic']:null;
            $url = isset($_POST['url'])?$_POST['url']:null;
            $desc = isset($_POST['desc'])?$_POST['desc']:null;
            $file = isset($_FILES['file']['name'])?$_FILES['file']['name']:null;
            $content = isset($_POST['content'])?$_POST['content']:null;
            $new_json = ["title"=>$name, "pic"=>$pic, "url"=>$url, "desc"=>$desc, "file"=>$file];
            $new_json = json_encode($new_json,true);
            $add_time = date("Y-m-d H:i:s",time());

            if($title|| $pic || $url || $desc||$file){
                $sql =mysqli_query($con,"insert into `wechat_material`(name,type,news_json,add_time,status) values ('".$name."',2,'".$new_json."','".$add_time."',1)");
                if($sql) {
                    echo "保存成功";
                }else{
                    echo "保存失败";
                }
            }else if ($content){
                $sql =mysqli_query($con,"insert into `wechat_material`(name,type,content,add_time,status) values ('".$name."',2,'".$content."','".$add_time."',1)");
                if($sql){
                    echo "保存成功";
                }else{
                    echo "保存失败";
                }
            }
        }

    }




}