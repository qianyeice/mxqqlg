<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Lottery;
use app\admin\model\Maple_leaves;
use think\facade\Request;
use app\admin\model\ViewRefund;

/**
 * 抽奖
 * name:张平
 * time:2018 03 29 14:25
 * Class Sekill
 * @package app\admin\controller
 */
function pr($var)
{
    $template = PHP_SAPI !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
    printf($template, print_r($var, true));
}
class Luckdrow extends adminController
{
    /**
     * 查询列表
     * name:岳军章
     * time:2018 04 6 14:25
     */

   public function index()
    {
        $model = new Lottery();

        $start = !is_null(input('page')) ? input('page') : 0;
        $limit = !is_null(input('limit')) ? input('limit') : 5;

        // 传递获取对应类型数据
        $select=$model->lottery_list($start,$limit);

       /* $count=$select['count'];
        unset($select['count']);*/
        $count = $model->nub();
        $date = date('Y-m-d H:i:s');
        $this->assign('date', $date);

        $this->assign('lists', $select);
        $this->assign('count', $count);
        $this->assign('limit', $limit);

        return view();
    }

    /**
    * 删除
    * name:岳军章
    * time:2018 04 6 14:25
    */
    public function delete()
    {
        $id =explode(",",input('id'));
        $model = new Lottery();
        $data=$model->dele($id);
        return $data;
    }

}