<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 15:58
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\GoodsSpu;
use app\admin\model\Procominfor;

class Cominformation extends adminController
{
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 商品信息
     * Date: 2018/3/29
     * Time: 15:59
     *
     * 吴杰 修改
     * 2018.5.15
     */

    public function index()
    {
        $kot = new Procominfor();
//        传输品牌的数据
        $apples = $kot->brand();
        $this->assign('brand', $apples);
//         传输运费模块的数据
        $beef = $kot->delivey_template();
        $this->assign('deli', $beef);
//        修改的查
        $id = input('get.idd');
        $banana = $kot->sel($id);
        $imgp = $kot->imgp($banana['spu']['content']);
        $this->assign('spu', $banana['spu']);
        $this->assign('vo', $banana['sku']);
        $this->assign('skt', $banana['sku']);
        $this->assign('imgp',$imgp);
        $this->assign('id', $id);
        return view('index');
    }

    public function upsave()
    {
        $dak = new Procominfor();
        $id = input('get.id');
        //dump($id);

        $apples = $dak->brand();
        $this->assign('brand', $apples);
        $beef = $dak->delivey_template();
        $this->assign('deli', $beef);


        $banana = $dak->sel($id);

        if (!empty($beef)) {
            $this->redirect('/index.php?s=admin/Comspecification/index&id=' . $id);
        } else {
            echo '添加失败';
        }

        $this->assign('vo', $banana);
        return view('index');
    }

    public function add()
    {
        $spu = $_POST;
        $data  = [];
        foreach ($spu['sku'] as $k=>$v){
            $data[$k]=[];
            if(is_array($v)){
                foreach ($v as $v1){
                    $data[$k][]=$v1;
                }
            }else{
                $data[$k]=$v;
            }

        }
        $spu['sku']=$data;

        $GoodsSpu = new GoodsSpu();
        $kot = new Procominfor();
        if(empty($spu['idd'])){
            $im=isset($spu['spu']["cont_img"])?$spu['spu']["cont_img"]:null;
            $img = $GoodsSpu->imga_add($_FILES, $im);

            $GoodsSpu->spu_add($spu, $data, $img);
        }else{
            $skp=$kot->sel($spu['idd']);
            if(isset($spu['dele'])){
            $dele=$GoodsSpu->dele($spu['dele']);
            }
            $up= $GoodsSpu->updel($_FILES, $spu,$skp);
        }
        header('Location:?s=admin/Productall/index&id=25.html');
    }
}