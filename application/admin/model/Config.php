<?php
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * ��ҳ֪ͨ��
 * Time: 2018\5\25  11:45
 * name��������
 */
class Config extends Model{

//��ҳ֪ͨ �޸ķ���
    public function xiugai($data){
//        var_dump($data);
//        die();
        $is_display=Db::table('config')->where('name','sy')->select();

        if($is_display[0]['is_display']==1){    //����
         $adda = $this->where('name','sy')->update(['value'=>$data]);
            return $adda;
        }else{
            return false;
        }
    }

//��ҳ֪ͨ  �ر�֪ͨ
    public function kaiguan($data){
//        var_dump($data);
//        die();
        $adda = $this->where('name','sy')->update(['is_display'=>$data]);
//        var_dump($adda);
//        die();
        return $adda;
    }

}