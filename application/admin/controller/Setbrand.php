<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 15:20
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Addbarnd;
use app\admin\model\Barnd;
use qiniuSdk\qiniuSdk;
use think\Image;

class Setbrand extends adminController {
    /**
     * 商品品牌设置重写
     * 吴杰
     * 2018.5.11
     * @return \think\response\View
     */
    public function index(){

        $id = input('get.id');
        if($id!=null){
            $menoy = new Addbarnd();
            $dast = $menoy->read($id);
            $this->assign('set',$dast);
            $this->assign('id',$id);
        }
        return view();
    }

    /**
     * 编辑后数据载入数据库
     * 吴杰
     * 2018.5.11
     */
    public function update(){
        $id=!is_null(input("get.id"))?input("get.id"):null;
            $name = input('post.name');
            $descript = input('post.descript');
            $url = input('post.url');
            $status = '1';
            $isrecommend = input('post.isrecommend');
            $sort = input('post.sort');
            $file = input('post.file');
            $logo = input('post.logo');
        if((!empty($logo))) {
            $filename = md5('Setbrand' . $_FILES['file']['name']) . time();
            $filetmp = $_FILES['file']['tmp_name']?$_FILES['file']['tmp_name']:null;
            if($filetmp==null){
                $hello = '请选择图片标识中的浏览进行图片上传操作';
                echo "<script> alert('{$hello}');history.go(-1); </script>";

            }
                elseif ($filetmp==!null){
                    $qin = new qiniuSdk();
                    $data = $qin->q_upload($filename, $filetmp);
                    $logo = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
                    $adm = new Addbarnd();
                    $set = $adm->sel($id, $name, $logo, $descript, $url, $status, $isrecommend, $sort);
                    if ($set>0) {
                        echo '<script>alert("成功！");location.href="?s=admin/brand/index"</script>';
                    } else {
                        echo '<script>alert("网络出错，请稍后重试！");location.href="?s=admin/brand/index"</script>';
                    }
                }
        }

    }
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 品牌设置
     * Date: 2018/3/29
     * Time: 15:59
     */

//    public function index()
//    {
//        $id = input('get.id');
//        if($id==null){
//            $name = input('post.name');
//            $descript = input('post.descript');
//            $url = input('post.url');
//            $status = '1';
//            $isrecommend = input('post.isrecommend');
//            $sort = input('post.sort');
//            $file = input('post.file');
//            $logo = input('post.logo');
//            if((!empty($logo))) {
//                $filename = md5('Setbrand' . $_FILES['file']['name']) . time();
//                $filetmp = $_FILES['file']['tmp_name'];
//
//                $qin = new qiniuSdk();
//                $data = $qin->q_upload($filename, $filetmp);
//                $logo = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
//
//
//                $adm = new Addbarnd();
//                $set = $adm->sel($id,$name,$logo,$descript,$url,$status,$isrecommend,$sort);
//
//                if ($id==null && $name!=null){
//                    $this->redirect('/index.php?s=admin/brand/index');
//                } else {
//
//                }
//            }else{
//                $logo = null;
//                $adm = new Addbarnd();
//                $set = $adm->sel($id,$name,$logo,$descript,$url,$status,$isrecommend,$sort);
//
//                if ($id==null && $name!=null){
//                    $this->redirect('/index.php?s=admin/brand/index');
//                } else {
//
//                }
//            }
//        }else{
//            $menoy = new Addbarnd();
//            $dast = $menoy->read($id);
//            $this->assign('set',$dast);
//
//            $name = input('post.name');
//            $descript = input('post.descript');
//            $url = input('post.url');
//            $status = '1';
//            $isrecommend = input('post.isrecommend');
//            $sort = input('post.sort');
//            $logo = input('post.logo');
//            $img = input('post.file');
//
//            if((!empty($logo))) {
//                $filename = md5('Setbrand' . $_FILES['file']['name']) . time();
//
//                $filetmp = $_FILES['file']['tmp_name'];
//
//                $qin = new qiniuSdk();
//                $data = $qin->q_upload($filename, $filetmp);
//                $logo = 'http://p5od7vvyw.bkt.clouddn.com/' . $data['key'];
//
////                $adm = new Addbarnd();
//                $set = $menoy->sel($id,$name,$logo,$descript,$url,$status,$isrecommend,$sort);
////                dump($set);
//
//                if ($id!=null && $name!=null){
//                    $this->redirect('/index.php?s=admin/brand/index');
//                } else {
//
//                }
//            }else{
//
//                $set = $menoy->sel($id,$name,$logo,$descript,$url,$status,$isrecommend,$sort);
//
//                if ($id!=null && $name!=null){
//                    $this->redirect('/index.php?s=admin/brand/index');
//                } else {
//
//                }
//            }
//        }
//
//        return view('index');
//    }

}