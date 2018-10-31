<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 14:55
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Category;

class Comclass extends adminController
{
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 商品分类管理
     * Date: 2018/3/29
     * Time: 9:59
     */
    public function index()
    {
        $table = new Category();
        $start = !is_null(input('page')) ? input('page')+1:1;
        $limit = !is_null(input('limit')) ? input('limit') : 5;
        $items = $table->cate($start, $limit);
        $this->assign('data', $items['data']);
        $this->assign('count', $items['count']);
        $this->assign('limit', $limit);
        return view('index');
    }

    /**
     * 商品分类操作
     * user:张平
     * @return $this|array
     */
    public function Post_open_close()
    {
        $table = new Category();
        $data = $table->close(input('id'), input('close'));
        $data = array(
            'type' => input('close'),
            'id' => input('id'),
            'data' => $data
        );
        return $data;
    }

    public function Post_next_cate(){
        $table = new Category();
        $data=$table->next_cate(input('id'));
        return $data;
    }

public function nextData(){
    $table = new Category();
    $data=$table->limitData($table->brothers(input('id')));
    return $data;
}
}