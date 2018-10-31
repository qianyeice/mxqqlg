<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\22 0022
 * Time: 9:29
 */

namespace app\api\model;

use think\Db;
use think\Model;

Class Evaluation_page extends Model
{
    /*
     * @param $datetime:用户当前评论时间
     * @param $is_shield:审核字段  默认为0
     * @return 返回查询后结果
     * Time: 2018\3\22  15:24 name：白锦国
     */
    function Method($member_id, $content, $spu_id)
    {
        $datetime = date('Y-m-d H:m:s');
        $is_shield = '0';
    for($i=0;$i<count($spu_id);$i++){
       $data=$this->query('call evaluationpage("'.$member_id.'","'.$content.'","'.$spu_id[$i]['spu_id'].'","'.$datetime.'","'.$is_shield.'")');
    }
  return $data[0][0];
    }

}