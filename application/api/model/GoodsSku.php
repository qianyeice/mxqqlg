<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/22
 * Time: 11:11
 */
namespace app\api\model;
use think\Db;
use think\Model;
class GoodsSku extends Model{
    /**
     * 根据副表编号查询主表商品；
     * time:18-3-22 13:38
     * author:陈明福
     * @param $key 传入商品编号
     * @return $array 返回数据包组
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     *
     *
     * 添加模糊查询功能
     * time:2018-5-24
     * 修改:胡伟
     */
    public function numberedSearch($key){
        $data=Db::name("goods_spu")->where('sn',$key)->select();
        $array=array();
        if($data){
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
        }else{
             $datas=DB::name("goods_spu")->whereLike("name","%".$key."%")->select();
//            return $datas;
            if($datas){
                $array["type"]=1;
                $array["lang"]=lang('success');
                $array["data"]=$datas;
            }else{
                $array["type"]=0;
                $array["lang"]=lang('noGoods');
                $array["data"]="";
            }
        }
        return $array;


//        if(!isset($data[0]["id"])){
//            $aaa=Db::name("goods_sku")->where('sn',$key)->select();
//            if(isset($aaa[0]["id"])){
//                $array["type"]=1;
//                $array["lang"]=lang('success');
//                $array["data"]=$aaa[0];
//            }else{
//                $array["type"]=0;
//                $array["lang"]=lang('noGoods');
//                $array["data"]='';
//            }
//        }else{
//            $array=array();
//            if(isset($data[0]["id"])){
//                $array["type"]=1;
//                $array["lang"]=lang('success');
//                $array["data"]=$data[0];
//            }else{
//                $array["type"]=0;
//                $array["lang"]=lang('noGoods');
//                $array["data"]='';
//            }
//        }
//        return $array;
    }

    public function specification($key)
        /**
         * 邓锋
         * 商品规格
         */
    {
        $data = Db::name("goods_sku")->where('spu_id', $key)->select();
           $array=array();
            if (isset($data[0]["spec"])) {
                $array["type"] = 1;
                $array["lang"] = lang('success');
                $array["data"] = $data;
            } else {
                $array["type"] = 0;
                $array["lang"] = lang('noGoods');
                $array["data"] = '';
            }
            return $array;
        }



    /**
     * 查询商品信息
     * time:18-3-22 16:27
     * author:陈明福
     * @param $array 商品id数据包
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public function commodityDetailsInquiry($array){
        $data=$this::all($array);
        return $data;
    }




    /**
     * 查询商品规格详情
     * time:18-6-20 14:34
     * author:冯云祥    spu_id商品id
     */
    public function goods($id)
    {
        $data = $this->field("thumb")->where('spu_id',$id)->select();
        $gsdata=Db::table('goods_spu')->field('thumb')->where('id',$id)->select();
        for ($i=1;$i<=count($data);$i++){
            $gsdata[$i]=$data[$i-1];
        }
        $array=[];
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$gsdata;
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]=$data;
        }
//        $array["data"]=$data->toArray();
//        return $data;
        return $array;
    }


    /**
     * 搜索页面新品促销商品
     * time:2018-5-24
     * author:胡伟
     * @param $types 商品类型
     * @param $num  返回的数量
     * @return array
     */
    public function product($types,$num){
        $datas=array();
        $data=DB::name("goods_spu")->field("id,name")->cache(7200)->where("type",$types)->select();

        if(count($data)>=$num){
            $arr=array();
            for($i=0;$i<$num;$i++){
                while(true){
                    $nu=rand(0,count($data)-1);
                    if(!in_array($nu,$arr)){
                        array_push($arr,$nu);
                        break;
                    }
                }
                $datas[$i]=$data[$nu];
            }
        }else{
            $datas= $data;
        }

        $array=array();
        $array["type"]=1;
        $array["lang"]=lang('success');
        $array["data"]=$datas;

        return $array;
    }

}