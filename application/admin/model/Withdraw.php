<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Withdraw extends Model
{
    public function edit ($type,$id){
      switch ($type){
          case 1:
              $return['data']='审核';
              break;
          case 2:
              $return['data']='发放';
              break;
          case 4:
              $return['data']='重发';
              $type=2;
              break;
      }
        $data= $this->where('id',$id)->data(array(
            'type'=>$type
        ))->update();
      if($type!=3){
          if($data==1){
              $return['type']=1;
              $return['data'].='成功';
          }else{
              $return['type']=0;
              $return['data'].='失败';
          }
      }else{
          if($data==1){
              $return['type']=1;
              $return['data']='放款失败,数据更新成功';
          }else{
              $return['type']=0;
              $return['data']='放款失败,数据更新失败';
          }
      }
       return $return;
    }

    public function withdraw_type($id,$order_num){
        $data=$this->where('id',$id)->data(['ordernum'=>$order_num])->update();
        if($data){
            $view=new View_withdraw();
            $data=$view->where('id',$id)->find();
        }
        return $data;
    }

    /*
     * 通过提现id查询用户id
     */
    public function withdraw_id($id){
       $member_id =$this->where('id',$id)->field('mid')->select();
       return $member_id[0]['mid'];
    }

    public function withdrawUp($id,$data){
        $update_data['type'] = 2;
        $update_data['wechatnum'] = $data['payment_no'];
        $update_data['poundage'] = $data['cmms_amt'];//手续费
        $update_data['withdrawtime'] = date('Y-m-d H:i:s');
      $data=$this->where('id',$id)->data($update_data)->update();
      if($data){
          $data=array(
              'type'=>1,
              'data'=>'发放成功!',
          );
      }else{
         cache('update',array('id'=>$id,'data'=>$data));
         $data=array(
             'type'=>2,
             'data'=>'数据更新不成功!'
         );
      }
      return $data;
    }

    public function user_ff($id){
        return Db::table('admin_user')->where('id',$id)->select();
    }
}