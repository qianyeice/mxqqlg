<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/5/8
 * Time: 0:15
 */

namespace app\admin\model;

use think\Model;

class View_wechat_keyword extends Model
{
    /**
     * 关键词回复数据显示内容
     * name:张平
     * @param $page
     * @param $count
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function keyWordData($page, $count)
    {
        $data = $this->field('id,souce,keyword,inserttime,souceid,eqin')->select();
        $arrays = array();
        foreach ($data as $vo) {
            if ($vo['eqin'] == 1) {
                $vo['keyword'] = '(等于)' . $vo['keyword'];
            } else {
                $vo['keyword'] = '(包含)' . $vo['keyword'];
            }
            if (!isset($arrays[$vo['souceid']])) {
                $arrays[$vo['souceid']] = array(
                    'id' => $vo['id'],
                    'souce' => $vo['souce'],
                    'souceid' => $vo['souceid'],
                    'inserttime' => $vo['inserttime'],
                    'keyword' => array(
                        $vo['keyword']
                    )
                );
            } else {
                $arrays[$vo['souceid']]['keyword'][] = '</br>' . $vo['keyword'];
            }
        }
        $array['count'] = count($arrays);
        $start = $page * $count;
        $length = $start + $count;
        if ($array['count'] < $length) {
            $length = $array['count'];
        }
        $data = [];
        foreach ($arrays as $vo) {
            $data[] = $vo;
            $start++;
            if ($start > $length) {
                break;
            }
        }
        $array['data'] = $data;
        return $array;
    }

    /**
     * 关键词回复数据的编辑显示内容
     * name:张平
     * @param $souceid回复素材id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function editData($souceid)
    {
        $data = $this->field('id,keyword,souce,souceid,eqin')->where('souceid', $souceid)->select();
        $array = array();
        if (count($data) > 1) {
            foreach ($data as $vo) {
                $array[] = array(
                    'word' => $vo['keyword'],
                    'keyid' => $vo['id'],
                    'eqin' => $vo['eqin']
                );
            }
        } else {
            $array[] = array(
                'word' => $data[0]['keyword'],
                'keyid' => $data[0]['id'],
                'eqin' => $data[0]['eqin']
            );
        }
        return $array;
    }

    /**
     * 关键词添加
     * @param $souceid
     * @param $data
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit_add($souceid, $data)
    {
        $array = [];
        $datas = [];
        $key = new Wechat_keyword();
        if (isset($data[0]['id'])) {
            $count = $this->where('souceid', $this->field('souceid')->where('id', $data[0]['id'])->find()['souceid'])->count();
            foreach ($data as $vo) {
                if (isset($vo['id'])) {
                    $array['id'][] = $vo['id'];
                    $data = $this->where(['id' => intval($vo['id']), 'keyword' => "" . $vo['value'] . "", 'souceid' => intval($souceid)])->find();
                    if ($data == null) {
                        $array['edit'] = 1;
                        $array['data'][] = array(
                            'id' => $vo['id'],
                            'data' => ['keyword' => "" . $vo['value'] . "", 'souce' => intval($souceid)]
                        );
                    }
                } else {
                    $data = $this->where('keyword', $vo['value'])->select();
                    if (count($data) == 0) {
                        $datas[] = ['souce' => $souceid, 'keyword' => "" . $vo['value'] . "", 'eqin' => "" . $vo['eqin'] . ""];
                    }
                }
            }
            if ($count > count($array['id']) && count($array['id']) != 0) {
                $return = $key->keyUpdate($array, true);
            } else {
                $return = $key->keyUpdate($array);
            }
            if (count($datas)!=0) {
                $return = $key->keyInsert($datas);

            }
        } else {
            foreach ($data as $vo) {
                $datas[] = ['souce' => $souceid, 'keyword' => "" . $vo['value'] . "", 'eqin' => "" . $vo['eqin'] . ""];
            }
            $insert = $key->keyInsert($datas);
            $return= $insert;
        }
        return $return;
    }


    public function textReplay($text,$object)
    {
        $where['keyword']=['like','%'.$text.'%'];
        $data = $this->field('souceid','keyword')->where($where)->select();
        if(count($data)==1){
            $result=$this->transmitText($object,$data['id']) ;
        }elseif(count($data)==0){
            $result=$this->transmitText($object,cache(config('weixin')['auto'])['id']);
        }elseif (count($data)>1){
            $string='您是要找';
            foreach ($data as $vo) {
                $string.=$vo.'</br>';
            }
            $string='吗？';
            $result= $this->transmitText($object,$data[0]['souceid'],$string);
        }
        return $result;
    }

    /**
     * 消息推送
     * @param $id
     * @return string
     */
    private function transmitText($object,$id,$key=false)
    {
        $startString = "<xml>
                <ToUserName>< ![CDATA[%] ]></ToUserName>
                <FromUserName>< ![CDATA[%] ]></FromUserName>
                <CreateTime>%</CreateTime>";
        $endString = "</xml>";
        $Tpl = '';
        if(is_string($key)){
            $Tpl='<MsgType>< ![CDATA[text] ]></MsgType><Content><![CDATA['.$key.']]></Content>';
        }else{
            $replayTpl = new Wechat_material();
            $data = $replayTpl->textTpl($id);
//        '素材类型（2文本text、1图文news、3图片image、4视频video）'
            switch ($data['type']) {
                case 1:
                    $data = json_decode($data['news_json'], true);
                    $length = count($data);
                    $Tpl = '<MsgType>< ![CDATA[news] ]></MsgType><ArticleCount>' . $length . '</ArticleCount><Articles>';
                    foreach ($data as $vo) {
                        $item = '<item><Title>< ![CDATA[' . $vo['title'] . '] ]></Title><Description>< ![CDATA[' . $vo['desc'] . '] ]></Description><PicUrl>< ![CDATA[' . $vo['file'] . '] ]></PicUrl><Url>< ![CDATA[' . $vo['url'] . ' ]></Url></item>';
                        $Tpl .= $item;
                    }
                    $Tpl.='</Articles>';
                    break;
                case 2:
                    $data=$data['content'];
                    $Tpl='<MsgType>< ![CDATA[text] ]></MsgType><Content><![CDATA['.$data.']]></Content>';
                    break;
                case 3:
                    $data=$data['image_url'];
                    $Tpl='<MsgType>< ![CDATA[image] ]></MsgType><Image><MediaId>< ![CDATA['.$data.'] ]></MediaId></Image>';
                    break;
                case 4:
                    $url=$data['video_url']; $title=$data['video_name'];$test=$data['video_test'];
                    $Tpl='<MsgType>< ![CDATA[video] ]></MsgType><Video><MediaId>< ![CDATA['.$url.'] ]></MediaId><Title>< ![CDATA['.$title.'] ]></Title><Description>< ![CDATA['.$test.'] ]></Description></Video>';
                    break;
            }
        }
        $message = $startString . $Tpl . $endString;
        $result = sprintf($message, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
}