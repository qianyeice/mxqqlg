<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/29
 * Time: 15:09
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\View_wechat_keyword;
use app\admin\model\Wechat_keyword;
use app\admin\model\Wechat_material;

class Wechat extends adminController
{
    /**
     * 微信素材
     * name:谢岸霖
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $wechat = new Wechat_material();
        $type = input('type') != null ? input('type') : 1;
        $array = array(
            'type' => $type,
        );
        if ($type == 1 || $type == 4) {
            $start = !is_null(input('page')) ? input('page')+1 : 1;
            $limit = !is_null(input('limit')) ? input('limit') : 20;
            if ($type == 1) {
                $data = $wechat->sel($start, $limit);
            } else {
                $keyword = new View_wechat_keyword();
                $data = $keyword->keyWordData($start, $limit);
            }
            $this->assign('data', $data['data']);
            $this->assign('count', $data['count']);
            $this->assign('limit', $limit);
        } elseif ($type == 2 || $type == 3 || $type == 4 || $type == 6) {    //消息回复,自动回复

            $data = $wechat->replayData($type);
            if (!is_null(input('id'))) {
                $myword = new View_wechat_keyword();
                $kk = $myword->editData(input('id'));
                $this->assign('mydata', $kk);
                $data = $wechat->replayData($type, input('id'));
            }
            $array['replay'] = $data;
            $data = $wechat->returnData();
            $array['data'] = $data;
        }
        $this->assign('array', $array);
        return view('index');
    }

    /**
     * 微信回复(消息自动回复/关注回复)素材选择编辑
     * name:张平
     * @return array|int|mixed|null|\PDOStatement|string|\think\Model
     */
    public function replayEditor()
    {
        $wechat = new Wechat_material();
        if (is_null(input('delete'))) {
            $data = $wechat->replayData(input('type'), input('id'));
        } else {
            $data = $wechat->replayData(input('type'), false, input('delete'));
        }
        return $data;
    }

    /**
     * 关键词及其规则的编辑/添加
     * @return mixed
     */
    public function post_KeyWord()
    {
        $keyword = new View_wechat_keyword();
        $data = json_decode(input('data'), true);
        $souceid = input('souceid');
        $data = $keyword->edit_add($souceid, $data);
        return $data;
    }

    /**
     * 关键词及其规则的删除
     * @return mixed
     */
    public function delete()
    {
        $key = new Wechat_keyword();
        $data = $key->myDelete(input('id'));
        return $data;
    }

    public function demo(){
        $wechat = new Wechat_material();
      $data=  $wechat-> textReplay('e');
      dump(cache(config('weixin')['auto']));
      dump($data);
    }

    public function chatdelect(){
        $id=input('id');
        $data=new Wechat_material();
        $data=$data->wechatdelect($id);
        return $data;
    }
}
