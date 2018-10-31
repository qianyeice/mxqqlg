<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/5/8
 * Time: 19:13
 */
namespace app\admin\model;

use think\Db;
use think\Model;

class Admin_package extends Model
{
    public function coupon()
    {
        $data=Db::table('package')->select();
        return $data;
    }

    /**
     * 礼品配置数据查询
     * 吴杰
     * 2018.5.9
     * @param $start
     * @param $limit
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_coupon($start,$limit){
        $cont=Db::table('package')->page($start,$limit)->select();
        $libao=$this->libao($cont);
       $juan=$this->juan($cont);
        for($i=0;$i<=count($libao);$i++){
            if(!empty($libao[$i]) && !empty($juan[$i])){
                $libao[$i]["pagname"]=$libao[$i]["pagname"].",".$juan[$i]["pagname"];
            }
        }
        $array=$libao+$juan;
        return $array;
    }

    /**
     * 查询大礼包下辖的小礼包信息
     * 吴杰
     * @param $cont 大礼包数据
     */
    public function libao($cont){
        $data= $this->select();

        $array=[];
        for($i=0;$i<count($cont);$i++){
            $name="";
            for($n=0;$n<count($data);$n++){
                if($cont[$i]['id']==$data[$n]['id']){
                    if($data[$n]["number"]<2){
                        $name=$name.",".$data[$n]["redname"]." x1";
                    }else{
                        $name=$name.",".$data[$n]["redname"]." x".$data[$n]["number"];
                    }

                }
            }
            if(!empty($name)){
                echo $name;
                $name=substr($name,1);
                $cont[$i]["pagname"]=$name;
                $cont[$i]["tit"]="红包";
                $array[$cont[$i]['id']]=$cont[$i];
            }
        }
        return $array;
    }

    /**
     * 查询大礼包下辖的优惠券信息
     * 吴杰
     * 2018.5.9
     * @param $cont
     */
    public function juan($cont){
        $data= DB::table('admin_coupon_package')->select();
        $array=[];
        for($i=0;$i<count($cont);$i++){
            $name="";
            for($n=0;$n<count($data);$n++){
                if($cont[$i]['id']==$data[$n]['id']){
                    if($data[$n]["number"]<2){
                        $name=$name.",".$data[$n]["conponname"]." x1";
                    }else{
                        $name=$name.",".$data[$n]["conponname"]." x".$data[$n]["number"];
                    }

                }
            }
            if(!empty($name)){
                $name=substr($name,1);
                $cont[$i]["pagname"]=$name;
                $cont[$i]["tit"]="礼劵";
                $array[$cont[$i]['id']]=$cont[$i];
            }
        }

        return $array;
    }

    /**
     * 删除礼包
     * 吴杰
     * @param $id
     */
    public function delet($id){
        return Db::table('package')->where("id",'in',$id)->update(["state"=>0]);
    }

    /**
     * 礼包编辑
     * 吴杰
     * @param $id 礼包id
     */
    public function find_coupon($id){
        $data= $this->select();
        $cont=Db::table('package')->where("id",$id)->select();
        $libao=$this->libao($cont);
        $juan=$this->juan($cont);
        for($i=0;$i<=count($data);$i++){
            if(!empty($libao[$i]) && !empty($juan[$i])){
                $libao[$i]["pagname"]=$libao[$i]["pagname"].",".$juan[$i]["pagname"];
            }
        }
        return $libao;
    }

    /**
     * 移除奖项
     * 吴杰
     * @param $id 礼包id
     * @param $name 需要移除的奖品
     */
    public function lete($id,$name){
        $con=Db::table("coupon_base")->where("couponname",$name)->select();
       if(!empty($con)){
           $date=Db::table("c_p_relationship")->where(["package_id"=>$id,"admin_coupon_id"=>$con[0]["id"]])->delete();
           return $date;
       }
        $mon=Db::table("admin_red")->where("name",$name)->select();
        if(!empty($mon)){
            $date=Db::table("r_p_relationship")->where(["package_id"=>$id,"admin_red_id"=>$mon[0]["id"]])->delete();

            return $date;
        }
    }
    public function get_sku($start,$limit){
        $data=Db::table("admin_red")->page($start,$limit)->order("id")->select();
        return $data;
    }
    public function count_sku(){
        $data=Db::table("admin_red")->field("id")->select();
        return count($data);
    }
    public function sele(){
       $array[0]= Db::table("admin_red")->select();
       $array[1]= Db::table("coupon_base")->where(["is_display"=>1,"is_delete"=>1])->select();
        return $array;
    }
    public function selec($id){
        $array[0]= Db::table("r_p_relationship")->field("admin_red_id")->where("package_id",$id)->select();
        $array[1]= Db::table("c_p_relationship")->field("admin_coupon_id")->where("package_id",$id)->select();
       return $array;
    }

    /**
     * 编辑中添加新的礼包奖品
     * 吴杰
     * @param $id 礼包id
     * @param $bag 选中的红包id
     * @param $con 选中的礼劵id
     */
    public function share($id,$bag,$con){
        if(!empty($bag)){
            for($i=0;$i<count($bag);$i++){
                if($bag[$i]!="") {
                    $data[$i] = ["admin_red_id" => $bag[$i], "package_id" => $id, "number" => 1];
                }
            }
           if(!empty($data)){
               for($i=0;$i<count($data);$i++) {
                   $array = Db::name("r_p_relationship")->insert($data[$i]);
               }
           }
        }
        if(!empty($con)){
            $date=array();
            for($i=0;$i<count($con);$i++){
                if($con[$i]!="") {
                    $date[] = ["admin_coupon_id" => intval($con[$i]), "package_id" => intval($id), "number" => 1];
                }
            }
            if(!empty($date)){
                for($i=0;$i<count($date);$i++){
                    Db::name("c_p_relationship")->insert($date[$i]);
                }
            }
        }
return true;
    }

    /**
     * 保存编辑设置的奖品数量
     * @param $id
     * @param $number
     * @param $con
     */
    public function upda($id,$number,$con){
        $array= Db::table("admin_red")->where("name",$con)->select();
        $arr= Db::table("coupon_base")->where("couponname",$con)->select();
        if(count($array)>0){
            return Db::name("r_p_relationship")->where(["admin_red_id"=>$array[0]["id"],"package_id"=>$id])->update(["number"=>$number]);
        }
        if(count($arr)>0){
           return Db::name("c_p_relationship")->where(["admin_coupon_id"=>$array[0]["id"],"package_id"=>$id])->update(["number"=>$number]);
        }
    }

    /**
     * 保存编辑的更改项
     * @param $id
     * @param $name
     * @param $start
     * @param $end
     * @param $frequeny
     */
    public function updat($id,$name,$start,$end,$frequeny){
        return Db::table('package')->where("id",$id)->update(["name"=>$name,"start_time"=>$start,"end_time"=>$end,"expiration_date"=>$frequeny]);
    }

    /**
     * 设置新的礼包
     * @param $name
     * @param $start
     * @param $end
     * @param $frequeny
     */
    public function newupdat($name,$start,$end,$frequeny){
        $date=
            ["cart_data"=>date('Y-m-d h:i:s', time()),"name"=>$name,"start_time"=>$start,"end_time"=>$end,"expiration_date"=>$frequeny,"state"=>1]
        ;
        $con=Db::table('package')->insert($date);
        $id=Db::table('package')->where(["cart_data"=>date('Y-m-d h:i:s', time()),"name"=>$name])->select();
        return Db::table("r_p_relationship")->insert(["admin_red_id"=>0,"package_id"=>$id[0]["id"]]);
    }
}