<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/17
 * Time: 15:34
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Wechat_material extends Model
{
    public function sel($start, $count)
    {
        $where['status'] = ['=', '1'];
        $data = listPage('id,name,type,content,news_json,UNIX_TIMESTAMP(add_time) as add_time,UNIX_TIMESTAMP(update_time) as update_time,upload_time ,status,image_media_id,image_url,video_test,video_name,video_url', $where, $start, $count, $this);
        $array['count'] = $data['count'];
        unset($data['count']);
        $array['data'] = $data;
        return $array;

    }

    public function addone($type, $first, $two, $title)
    {
        $two['0'] = $first;
        $all = json_encode($two);
        $data = [
            'id' => null,
            'name' => $title,
            'type' => $type,
            'content' => null,
            'news_json' => $all,
            'add_time' => date("Y/m/d h:i:s"),
            'update_time' => date("Y/m/d h:i:s"),
            'upload_time' => date("Y/m/d h:i:s"),
            'status' => '1',
            'image_media_id' => null,
            'image_url' => null,
            'video_test' => null,
            'video_name' => null,
            'video_url' => null
        ];
        return $data = $this->insert($data);
    }

    public function addtwo($type, $msgtext, $title)
    {
        $data = [
            'id' => null,
            'name' => $title,
            'type' => $type,
            'content' => $msgtext,
            'news_json' => null,
            'add_time' => date("Y/m/d h:i:s"),
            'update_time' => date("Y/m/d h:i:s"),
            'upload_time' => date("Y/m/d h:i:s"),
            'status' => '1',
            'image_media_id' => null,
            'image_url' => null,
            'video_test' => null,
            'video_name' => null,
            'video_url' => null
        ];
        return $data = $this->insert($data);
    }

    public function addthree($title, $type, $logo)
    {
        $data = [
            'id' => null,
            'name' => $title,
            'type' => $type,
            'content' => null,
            'news_json' => null,
            'add_time' => date("Y/m/d h:i:s"),
            'update_time' => date("Y/m/d h:i:s"),
            'upload_time' => date("Y/m/d h:i:s"),
            'status' => '1',
            'image_media_id' => null,
            'image_url' => $logo,
            'video_test' => null,
            'video_name' => null,
            'video_url' => null
        ];
        return $data = $this->insert($data);
    }

    public function addfour($type, $logo, $title, $videotitle, $videodesc)
    {
        $data = [
            'id' => null,
            'name' => $title,
            'type' => $type,
            'content' => null,
            'news_json' => null,
            'add_time' => date("Y/m/d h:i:s"),
            'update_time' => date("Y/m/d h:i:s"),
            'upload_time' => date("Y/m/d h:i:s"),
            'status' => '1',
            'image_media_id' => null,
            'image_url' => null,
            'video_test' => $videodesc,
            'video_name' => $videotitle,
            'video_url' => $logo
        ];
        return $data = $this->insert($data);
    }

    /**
     * 消息回复/自动回复的素材内容集
     * name:张平
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function returnData()
    {
        $where['status'] = ['=', '1'];
        $data = $this->field('id,name')->where($where)->select();

        return $data;
    }


    function edit($id)
    {
        $data = Db::table('wechat_material')->where('id', $id)->select();
        return $data;
    }

    function xiugai($id, $type, $array, $kong, $title)
    {
        $kong['0'] = $array;
        $all = json_encode($kong);
        $data = $this->where('id', $id)->update([
            'name' => $title,
            'type' => $type,
            'content' => null,
            'news_json' => $all,
            'update_time' => date("Y/m/d h:i:s"),
            'image_media_id' => null,
            'image_url' => null,
            'video_test' => null,
            'video_name' => null,
            'video_url' => null
        ]);
        return $data;
    }

    function xiugaitwo($id, $type, $msgtext, $title)
    {
        $data = $this->where('id', $id)->update([
            'name' => $title,
            'type' => $type,
            'content' => $msgtext,
            'news_json' => null,
            'update_time' => date("Y/m/d h:i:s"),
            'image_media_id' => null,
            'image_url' => null,
            'video_test' => null,
            'video_name' => null,
            'video_url' => null
        ]);
        return $data;
    }

    function xiugaithree($id, $title, $type, $logo)
    {
        $data = $this->where('id', $id)->update([
            'name' => $title,
            'type' => $type,
            'content' => null,
            'news_json' => null,
            'update_time' => date("Y/m/d h:i:s"),
            'image_url' => $logo,
            'video_test' => null,
            'video_name' => null,
            'video_url' => null
        ]);
        return $data;
    }

    function xiugaifour($id, $type, $logo, $title, $videotitle, $videodesc)
    {
        $data = $this->where('id', $id)->update([
            'name' => $title,
            'type' => $type,
            'content' => null,
            'news_json' => null,
            'update_time' => date("Y/m/d h:i:s"),
            'image_media_id' => null,
            'image_url' => null,
            'video_test' => $videodesc,
            'video_name' => $videotitle,
            'video_url' => $logo
        ]);
        return $data;
    }

    public function replayData($type, $id = false, $delete = false)
    {
        $data = $this->replayCacheData($type, $id, $delete);
        return $data;
    }

    private function replayCacheData($type, $id = false, $delete = false)
    {
        if ($type == 2) {
            $cacheName = config('weixin')['follow'];
        } elseif ($type == 3) {
            $cacheName = config('weixin')['auto'];
        }
        if ($delete == 1) {
            if (cache($cacheName, null)) {
                $data = 1;
            };
        } else {
            if ($type == 6) {
                if($id){
                    $data = $this->field('id,name,type')->where('id', $id)->find();
                }else{
                    $data=null;
                }
            } else {
                if ($id) {
                    $data = $this->field('id,name,type')->where('id', $id)->find();
                    cache($cacheName, $data);
                    $data = cache($cacheName);
                } else {

                    if (!cache($cacheName)) {
                        $data = null;
                    } else {
                        $data = cache($cacheName);
                    }
                }
            }
        }
        return $data;
    }

    //        '素材类型（2文本text、1图文news、3图片image、4语音voice、5视频video）'

    public function textTpl($id)
    {
        $where['id'] = ['=', $id];
        $type = $this->field('type')->where($where)->find()['type'];
        $field = 'type,';
        switch ($type) {
            case 1:
                $field .= 'news_json';
                break;
            case 2:
                $field .= 'content';
                break;
            case 3:
                $field .= 'image_url';
                break;
            case 4:
                $field .= 'video_url,video_name,video_test';
                break;
        }
        $data = $this->field($field)->where($where)->find();
        return $data;
    }

    public function wechatdelect($id){
        $data=$this->where('id',$id)->delete();
        return $data;
    }



    /**
     * 全局->微信管理->编辑和添加
     * name:P84->廖怡
     * abc->编辑
     * def->添加
     */
    public function abc($intid,$name,$new_json,$add_time)
    {


        $s=Db::table('wechat_material')
            ->where('id', $intid)
            ->update([
                'name'  => $name,
                'type' => '2',
                'news_json' =>$new_json,
                'add_time'=>$add_time,
                'status'=>1,
            ]);
        return $s;

    }


    public function def($name,$new_json,$add_time)
    {
        $data = ['name' => $name, 'type' => '2','news_json' => $new_json, 'add_time' => $add_time,'status' => '1'];
        $z= Db::table('wechat_material')->insert($data);
        return $z;

    }
    /**
     *  end
     */






}