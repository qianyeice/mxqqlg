<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/5/10
 * Time: 16:30
 */

namespace app\admin\model;

use think\Model;

class Wechat_keyword extends Model
{
    /**
     * 关键词规则的添加
     * @param $data 需要添加的数据
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function keyInsert($data)
    {
        if (count($data) != 0) {
            $array = array();
            $this->startTrans();
            $num=0;
            foreach ($data as $v) {
                $mydata = $this->where('keyword',$v['keyword'])->select();
                if (count($mydata) == 0) {
                    $data = $this->insertGetId($v);
                    $num++;
                    if($data){
                        $array[] = $data;
                    }
                }
            }
           if($num==0){
               $return['type'] = 4;
               $return['data'] = '数据已存在!';
           }else{
               if ($num == count($array)) {
                   $this->commit();
                   $return['type'] = 1;
                   $return['data'] = '数据插入成功!';
               } else {
                   $this->rollback();
                   $return['type'] = 0;
                   $return['data'] = '数据插入失败!';
               }
           }
        } else {
            $return['type'] = 2;
            $return['data'] = '无新增数据!';
        }
        return $return;
    }

    /**
     * 关键词规则的更新
     * @param $data
     * @param bool $type
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function keyUpdate($data, $type = false)
    {
        if (count($data) != 0) {
            $this->startTrans();
            $id = $data['id'];
            $error = [];
            if (isset($data['data'])) {
                foreach ($data['data'] as $v) {
                    $data = $this->where('id', $v['id'])->data($v['data'])->update();
                    if ($data) {
                        $error[] = array(
                            'id' => $v['id'],
                            'keyword' => $v['keyword']
                        );
                    }
                }
            }
            if ($type) {
                $souce = $this->field('souce')->where('id', $data['id'][0])->find();
                $where['souce'] = ['=', $souce['souce']];
                $where['status'] = ['=', 1];
                $where['id'] = ['notin', $id];
                if (count($id) == 1) {
                    $where['id'] = ['<>', $id[0]];
                    $kk = $this->where($where)->select();
                } else {
                    $kk = $this->where($where)->select();
                }
                foreach ($kk as $vo) {
                    $kk = $this->where('id', $vo['id'])->data('status', '0')->update();
                    if (!$kk) {
                        $error[] = array(
                            'id' => $vo['id'],
                            'keyword' => $vo['keyword']
                        );
                    }
                }
            }
            if (count($error) == 0) {
                $this->commit();
                $return['type'] = 1;
                $return['data'] = '编辑成功!';
            } else {
                $this->rollback();
                $return['type'] = 0;
                $return['data'] = '编辑失败!';
            }
            return $return;
        } else {
            $return['type'] = 0;
            $return['data'] = '无需要更新数据!';
        }
        return $return;
    }

    /**
     * 关键词规则的删除
     * @param $id
     * @return mixed
     */
    public function myDelete($id)
    {
        $data=$this->where('souce',intval($id))->delete();
        if($data>0){
            $return['type']=1;
            $return['data']='删除成功!';
        }else{
            $return['type']=0;
            $return['data']='删除失败!';
        }
        return $return;
    }

}