<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/29
 * Time: 11:03
 */
namespace app\admin\controller;
use app\admin\model\Promotion_commodity_seckill;

use adminController\adminController;
use app\admin\model\Promotion_commodity;
use app\admin\model\View_goods_sku_spec;
use app\admin\model\Promotion_commodity_relation;
use app\admin\model\View_promotion_commodity;
use think\facade\Request;
use think\Db;

function pr($var)
{
    $template = PHP_SAPI !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
    printf($template, print_r($var, true));
}
class Sekilleditor extends adminController
{
    /**
     * 秒杀活动添加
     * author:岳军章
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function add()
    {
        $val = input('get.data');
        $lists = base64_decode($val);
        $array = '';
        if($lists != ''){
            $promotion=new View_goods_sku_spec();
            $aa=json_decode($lists,true);
            foreach ($aa as $key=>$v){
                if($v==null || $v==''){
                }else{
                    $data=$promotion->goods_sku($v);
                    $array[$key]=$data;
                }
            }
        }
        $this->assign("lists",$array);

        return view();
    }

    /**
     * 秒杀活动详情
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * name:岳军章
     * time 2018/4/18
     */
    public function edit(){

        $id = input('get.Promotion_commodity_id');

        $commodity =  new Promotion_commodity();
        $moder     = new Promotion_commodity_seckill();
        $relation  =  new Promotion_commodity_relation();
        //查询
        $finds = $moder->edit_finds($id);
        $this->assign('finds',$finds);
        $date=date('Y-m-d', $finds['date']);
        $this->assign('date',$date);
//        dump($date);
//        exit;

        $this->assign('Promotion_commodity_id',$id);
        $data2  =  $relation->edit_spu_select($id);
        $this->assign("data2",$data2);
//        dump($data2);
//        exit();
        return view();
    }
   /* public function a(){
        $edit1['name'] = input('post.name');
        $data['date'] = input('post.date'); //日期
        $data['Screenings'] = input('post.Screenings');  //场次
        $data['spu_price'] = input('post.spu_price');
        $edit1['is_display'] = input('post.is_display');

        // 获取时间戳
        $start = strtotime($data['date']);

        if ($data['Screenings'] == 1 ){
            $data['Screenings_start_time'] = $start+86400*9;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+86400*2;
        }
        if ($data['Screenings'] == 2 ){
            $data['Screenings_start_time'] = $start+86400*11;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+86400;
        }
        if ($data['Screenings'] == 3 ){
            $data['Screenings_start_time'] = $start+86400*12;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+86400*3;
        }
        if ($data['Screenings'] == 4 ){
            $data['Screenings_start_time'] = $start+86400*15;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+86400;
        }
        if ($data['Screenings'] == 5 ){
            $data['Screenings_start_time'] = $start+86400*15;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+86400*5;
        }
        //修改

    }*/


    /**
     * 秒杀活动编辑
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * name:岳军章
     * time 2018/4/20
     */
   public function editor()
   {


       $commodity =  new Promotion_commodity();
       $relation  =  new Promotion_commodity_relation();

       $validate = new \app\admin\validate\Sekill;

       $a=Request::post("array/a");
       $b=Request::post("shop_data/a");

       $data['date']=$a['date'];
       $data['Screenings'] = $a['Screenings'];

       $edit1['name'] = $a['name'];
       $edit1['is_display'] = $a['is_display'];
       $edit1['Screenings'] = $a['Screenings'];
       $edit1['number'] = $a['number'];





       $id = input('get.Promotion_commodity_id');
//       $edit1['name'] = input('post.name');
//       $edit1['is_display'] = input('post.is_display');

//       $data['date'] = input('post.date'); //日期
//       $edit1['Screenings'] = input('post.Screenings');
//       $data['Screenings'] = input('post.Screenings'); //场次
//       $data['spu_price'] = input('post.spu_price');


       // 获取时间戳
       $start = strtotime($data['date']);
       //$vo = date('Y-m-d H:i:s', $data['Screenings_end_time']);//时间戳转时间格式
       //  获取开始/结束时间
       if ($data['Screenings'] == 1 ){
           $data['Screenings_start_time'] = $start+3600*9;
           $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*2;
       }
       if ($data['Screenings'] == 2 ){
           $data['Screenings_start_time'] = $start+3600*11;
           $data['Screenings_end_time']   = $data['Screenings_start_time']+3600;
       }
       if ($data['Screenings'] == 3 ){
           $data['Screenings_start_time'] = $start+3600*12;
           $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*3;
       }
       if ($data['Screenings'] == 4 ){
           $data['Screenings_start_time'] = $start+3600*15;
           $data['Screenings_end_time']   = $data['Screenings_start_time']+3600;
       }
       if ($data['Screenings'] == 5 ){
           $data['Screenings_start_time'] = $start+3600*16;
           $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*7;
       }



       //修改
       unset($data['date']);
       if (!$validate->check($data,$edit1)) {
           $array['lang'] = $validate->getError();
           //验证传参
           $this->assign('data',$array);
       } else {
           if($id != null){
               $edit2     =  $relation->relation_edit($id,$data);
               $edit1     =  $commodity->commodity_edit($id,$edit1);
               if ($edit2 && $edit1 ) {
                   //跳转页面
                    $this->redirect('/?s=admin/Sekill/index');
               } else {
                   $this->error('失败');
               }
           } else {
               $edit1['panduan']=1;
               $edit1['Screenings_start_time']=$data['Screenings_start_time'];
               $edit1['Screenings_end_time']=$data['Screenings_end_time'];
               $ids = Db::name('Promotion_commodity')->insertGetId($edit1);

               $data['Promotion_commodity_id'] = $ids;

               //$vo =array_keys($_POST['spu_id']);
               $spu_id  =input('post.spu_id/a');


               if(count($spu_id)> 0 ){
                   $vo  =array_keys($spu_id);

                   $count=count($vo);
                   for ($i=0;$i<$count;$i++){
                       $keys=$vo[$i];

                       $data['spu_id'] = $keys;
                       $data['spu_number'] = $_POST ["spu_number"][$keys];
                       $data['spu_surplus_number'] = $_POST ["spu_surplus_number"][$keys];
//                       $data['sup_personal'] = $_POST ["sup_personal"][$keys];
                       // $add = $relation-> relation_add($data);
//                       unset($data['Screenings']);
//                       unset($data['Screenings_start_time']);

                       $add =  Db::name('Promotion_commodity_relation')->insert($data);
                   }
               } else {
//                   unset($data['Screenings']);
//                   unset($data['Screenings_start_time']);
                   $add =  Db::name('Promotion_commodity_relation')->insert($data);
               }


               if ( $add && $ids) {
                   //跳转页面
//                   $success=new Succeed();
//                  return  $success->index();
                   $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Sekill&a=index'));

//                    $this->redirect('?s=admin/Sekilleditor/index');
               } else {
                   $this->error('失败');
               }

           }

       }
   }

    /**
     * 秒杀活动编辑
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * name:null
     * time 2018/4/20
     */
    public function msedit(){
        $commodity =  new Promotion_commodity();
        $relation  =  new Promotion_commodity_relation();

        $validate = new \app\admin\validate\Sekill;

        $a=Request::post("array/a");
        $b=Request::post("shop_data/a");

        $data['date']=$a['date'];
        $data['Screenings'] = $a['Screenings'];

        $edit1['name'] = $a['name'];
        $edit1['is_display'] = $a['is_display'];
        $edit1['Screenings'] = $a['Screenings'];
        $edit1['number'] = $a['number'];


        $id = input('get.Promotion_commodity_id');
        $start = strtotime($data['date']);

        //  获取开始/结束时间
        if ($data['Screenings'] == 1 ){
            $data['Screenings_start_time'] = $start+3600*9;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*2;
        }
        if ($data['Screenings'] == 2 ){
            $data['Screenings_start_time'] = $start+3600*11;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600;
        }
        if ($data['Screenings'] == 3 ){
            $data['Screenings_start_time'] = $start+3600*12;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*3;
        }
        if ($data['Screenings'] == 4 ){
            $data['Screenings_start_time'] = $start+3600*15;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600;
        }
        if ($data['Screenings'] == 5 ){
            $data['Screenings_start_time'] = $start+3600*16;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*7;
        }


        unset($data['date']);
        if (!$validate->check($data,$edit1)) {
            $array['lang'] = $validate->getError();
            //验证传参
            $this->assign('data',$array);
        } else {
            if($id != null){
                $edit2     =  $relation->relation_edit($id,$data);
                $edit1     =  $commodity->commodity_edit($id,$edit1);
                if ($edit2 && $edit1 ) {
                    //跳转页面
                    $this->redirect('/?s=admin/Sekill/index');
                } else {
                    $this->error('失败');
                }
            } else {
                $edit1['panduan']=1;
                $edit1['Screenings_start_time']=$data['Screenings_start_time'];
                $edit1['Screenings_end_time']=$data['Screenings_end_time'];
                $ids = Db::name('Promotion_commodity')->insertGetId($edit1);



                $data['Promotion_commodity_id'] = $ids;

                //$vo =array_keys($_POST['spu_id']);
                $spu_id  =input('post.spu_id/a');

                foreach ($b as $vo) {
                    $array = array(
                        'Promotion_commodity_id' => $ids,
                        'spu_id' => $vo['id'],
                        'spu_number' => $vo['spu_number'],
                        'spu_price' => $vo['spu_price']
                    );
                    $data=Db::name('Promotion_commodity_relation')->insert($array);
                }


//                if(count($spu_id)> 0 ){
//                    $vo  =array_keys($spu_id);
//
//                    $count=count($vo);
//                    for ($i=0;$i<$count;$i++){
//                        $keys=$vo[$i];
//
//                        $data['spu_id'] = $keys;
//                        $data['spu_number'] = $_POST ["spu_number"][$keys];
//                        $data['spu_surplus_number'] = $_POST ["spu_surplus_number"][$keys];
////                       $data['sup_personal'] = $_POST ["sup_personal"][$keys];
//                        // $add = $relation-> relation_add($data);
////                       unset($data['Screenings']);
////                       unset($data['Screenings_start_time']);
//
//                        $add =  Db::name('Promotion_commodity_relation')->insert($data);
//                    }
//                } else {
////                   unset($data['Screenings']);
////                   unset($data['Screenings_start_time']);
//                    $add =  Db::name('Promotion_commodity_relation')->insert($data);
//                }


                if ( $data && $ids) {
                    return array(
                        'type'=>'1',
                        'lang'=>'成功'
                    );

                    //跳转页面
//                   $success=new Succeed();
//                  return  $success->index();
//                    $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Sekill&a=index'));

//                    $this->redirect('?s=admin/Sekilleditor/index');
                } else {
                    return array(
                        'type'=>'0',
                        'lang'=>'失败'
                    );
//                    $this->error('失败');
                }

            }

        }


    }

    /**
     * 秒杀活动真的是编辑
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * name:null
     * time 2018/4/20
     */
    public function edittttt(){
        $commodity =  new Promotion_commodity();
//        $relation  =  new Promotion_commodity_relation();

        $validate = new \app\admin\validate\Sekill;

        $a=Request::post("array/a");
//        $b=Request::post("shop_data/a");
        $posiID=input('id');
        $data['date']=$a['date'];
        $data['Screenings'] = $a['Screenings'];

        $edit1['name'] = $a['name'];
        $edit1['is_display'] = $a['is_display'];
        $edit1['Screenings'] = $a['Screenings'];
        $edit1['number'] = $a['number'];


        $id = input('Promotion_commodity_id');
        $start = strtotime($data['date']);

        //  获取开始/结束时间
        if ($data['Screenings'] == 1 ){
            $data['Screenings_start_time'] = $start+3600*9;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*2;
        }
        if ($data['Screenings'] == 2 ){
            $data['Screenings_start_time'] = $start+3600*11;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600;
        }
        if ($data['Screenings'] == 3 ){
            $data['Screenings_start_time'] = $start+3600*12;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*3;
        }
        if ($data['Screenings'] == 4 ){
            $data['Screenings_start_time'] = $start+3600*15;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600;
        }
        if ($data['Screenings'] == 5 ){
            $data['Screenings_start_time'] = $start+3600*16;
            $data['Screenings_end_time']   = $data['Screenings_start_time']+3600*7;
        }


        unset($data['date']);
        if (!$validate->check($data,$edit1)) {
            $array['lang'] = $validate->getError();
            //验证传参
            $this->assign('data',$array);
        } else {
            if($id != null){
//                $edit2     =  $relation->relation_edit($id,$data);
                $edit1     =  $commodity->commodity_edit($id,$edit1);
                if ($edit1 ) {
                    //跳转页面
                    $this->redirect('/?s=admin/Sekill/index');
                } else {
                    $this->error('失败');
                }
            } else {

                $edit1['panduan']=1;
                $edit1['Screenings_start_time']=$data['Screenings_start_time'];
                $edit1['Screenings_end_time']=$data['Screenings_end_time'];
                $ids = Db::name('Promotion_commodity')->where('id',$posiID)->update($edit1);


//                $data['Promotion_commodity_id'] = $ids;
//                $spu_id  =input('post.spu_id/a');

//                foreach ($b as $vo) {
//                    $array = array(
//                        'Promotion_commodity_id' => $ids,
//                        'spu_id' => $vo['id'],
//                        'spu_number' => $vo['spu_number'],
//                        'spu_price' => $vo['spu_price']
//                    );
//                    $data=Db::name('Promotion_commodity_relation')->insert($array);
//                }

                if ($ids) {
                    return array(
                        'type'=>'1',
                        'lang'=>'成功'
                    );
                } else {
                    return array(
                        'type'=>'0',
                        'lang'=>'失败'
                    );
//                    $this->error('失败');
                }

            }

        }


    }

    /**
     * 秒杀活动移除商品
     * @return array 返回操作状态包
     * name:岳军章
     * time 2018/4/20
     */
    public function remove(){
        //接收商品ID
        $id=Request::post('id');
        $promotionID=Request::post('promotionID');

        $promotion=new Promotion_commodity_relation();
        $data=$promotion->romove_spu($id,$promotionID);
        return $data;
    }

    /**
     * 选择商品页面显示查询
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *  * name:岳军章
     * time 2018/4/19
     */
    public function goods(){
        $id = input("get.id");
        $page=isset($_GET["page"])?$_GET["page"]:1;
        $type=isset($_GET["type"])?$_GET["type"]:2;
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :5;
        $view_goods_sku=new View_goods_sku_spec();
        $data=$view_goods_sku->get_sku($start,$limit);
        $total=$view_goods_sku->count_sku();
//        $pagenumber=ceil($total/$limit);
//        $this->assign("pagenumber",$pagenumber);
        $this->assign("data",$data);
        $this->assign("limit",$limit);
        $this->assign("count",$total);
        $this->assign("type",$type);
        $this->assign("id",$id);
        return view();
    }

    /**
     * 秒杀活动商品新增
     * @return array 返回操作状态数据包
     * @throws \Exception.AggregateException
     * name:岳军章
     * time 2018/4/20
     */
    public function Commodity_addition(){
        $array=array();
        //id组获取
        $id_data=Request::post('data/a');
        if(gettype($id_data)!="array"){
            $array["type"]=2;
            return $array;
        }
        $id=Request::post('id');
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->Add_goods($id_data,$id);

        return $data;
    }

   /* public function goods_addition(){
        $array=array();
        //id组获取
//        $id_data=Request::post('data/a');
        $id_data=input('post.ca');
        $promotion=new View_goods_sku_spec();
        $aa=json_decode($id_data,true);
        foreach ($aa as $key=>$v){
            if($v==null || $v==''){

            }else{
                $data=$promotion->goods_sku($v);
                $array[$key]=$data;
            }
        }
        echo json_encode($array);
        if(gettype($id_data)!="array"){
            $array["type"]=2;
            return $array;
        }


        $promotion=new Promotion_commodity_relation();
        $data=$promotion->edit_spu_select($id_data);

      $view_goods_sku=new View_goods_sku_spec();
        $data=$view_goods_sku->goods_sku($id_data);

       echo json_encode($array);
    }*/


    /**
     *  秒杀活动限量
     * @return array 操作状态返回
      * name:岳军章
     * time 2018/4/20
     */
    public function spu_numbers(){
        $id=Request::post('id');
        $number=Request::post('spu_number');
        $promotionID=Request::post('promotionID');
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->spu_number($id,$number,$promotionID);
        return $data;
    }

    /**
     * 秒杀活动剩余库存
     * @return array 操作状态返回
     * name:岳军章
     * time 2018/4/20
     */
    public function Inventory_modification(){
        $id=Request::post('id');
        $number=Request::post('spu_surplus_number');
        $promotionID=Request::post('promotionID');
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->Inventory_modification($id,$number,$promotionID);
        return $data;
    }


    /**
     * 秒杀活动剩余价格
     * @return array 操作状态返回
     * name:岳军章
     * time 2018/4/20
     */
    public function Inventory_jiage(){
        $id=Request::post('id');
        $number=Request::post('spu_surplus_number');
        $promotionID=Request::post('promotionID');
        $promotion=new Promotion_commodity_relation();
        $data=$promotion->Inventory_jiage($id,$number,$promotionID);
        return $data;
    }


    /**
     * 秒杀活动单人限购
     *@return array 操作状态返回
     */

    public function sup_personals()
    {
        $id=Request::post('id');
        $Price=Request::post('sup_personal');
        $promotionID=Request::post('promotionID');

        $promotion=new Promotion_commodity_relation();
        $data=$promotion->sup_personal($id,$Price,$promotionID);
        return $data;
    }

    /**
     * 秒杀活动删除
     * @return array
     * name:岳军章
     * time 2018/4/20
     */
    public function delete(){
        $id=Request::post("id");
        $promotion=new Promotion_commodity();
        $data=$promotion->promotion_delete($id);
        return $data;
    }


    /**
     * 超类转数组
     * @param $array 待处理的超类对象
     * @return array 处理后的数组对象
     *  * name:岳军章
     * time 2018/4/19
     */
    private function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key]=$this->object_array($value);
            }
        }
        return $array;
    }
}