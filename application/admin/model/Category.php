<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 15:24
 */

namespace app\admin\model;

use think\Model;

class Category extends Model
{
    /**
     * 读取商品分类数据
     * @param $start
     * @param $count
     * @return string
     */
    public function cate($start, $count)
    {
        $where['status'] = ['<>', '2'];
        $where['parent_id'] = ['=', '0'];
        $data = listPage('id,name,parent_id,status', $where, $start, $count, $this);
        $array['count'] = $data['count'];
        unset($data['count']);
        $data = $this->limitData($data);
        $array['data'] = $data;
        return $array;
    }

    /**
     * 对商品分类数据进行更新(启用/关闭/删除)
     * user:张平
     * @param $id分类id
     * @param $close更新类别
     * @return Category|array|float|int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function close($id, $close)
    {
        if ($close == 2) {
            $cate = $this->where('parent_id', $id)->count();
            if ($cate != 0) {
             $data= $this->guodu($this->brothers($id));
             $array=[];
             $array[]= $this->return_close($id,'2');
             foreach ($data as $v){
               foreach ($v as $k){
                   $array[]= $this->return_close($k['id'],'2');
               }
             }
             $data=array_product($array);
            } else {
                $data = $this->return_close($id, $close);
            }
        } else {
            $data = $this->return_close($id, $close);
        }
        return $data;
    }

    /**
     * 数据操作
     * @param $id
     * @param $close
     * @return $this
     */
    private function return_close($id, $close)
    {
        $where['id']=['=',$id];
        $where['status']=['<>','2'];
        $data = $this->where($where)->update(['status' => $close]);
        return $data;
    }

    /**
     * 获取一层分类及其是否有下级的状态并返回
     * name:张平
     * @param $data
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function limitData($data)
    {
        foreach ($data as $key => $vo) {
            $children = $this->brothers($vo['id']);
            if (count($children) != 0) {
                $data[$key]['children'] = 0;
            } else {
                $data[$key]['children'] = 1;
            }
        }
        return $data;
    }


    /**
     * 动态查询多级数据
     * user:张平
     * @param $id 相关商品id
     * @param int $type 操作状态(编辑/添加下级)
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function category($id, $type = 0)
    {
        $array = array();
        $num = 0;
        $snum = 1;
        //下一级分类
        $data = $this->brothers($id);
        if (count($data) != 0) {
            $array[$num] = $data;
            $num++;
        }

        while (1) {
            //传入id分类
            $data = $this->brothers($id, 1);
            $array[$num]['parent_id'] = $data[0]['id'];
            $string[$snum] = $data[0]['name'];
            //同级分类
            $data = $this->brothers($data[0]['parent_id']);
            $array[$num][] = $data;
            $id = $data[0]['parent_id'];
            if ($id == 0) {
                break;
            }
            $num++;
            $snum++;
        }
        //$type=1时为添加下级页面
        if ($type != 1) {
            array_shift($string);
        }
        $string = array_reverse($string);
        $array = array_reverse($array);
        $string = implode('>>', $string);
        return array($array, $string);
    }

    /**
     * 获取相关商品分类数据
     * user:张平
     * @param $id 商品id
     * @param int $type 查询类别(本身/父级)
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function brothers($id, $type = 0)
    {
        $where['status']=['<>',2];
        if ($type) {
            //当前id的数据
            $where['id']=['=',$id];
            return $this->where($where)->select();
        } else {
            //当前id的子级数据
            $where['parent_id']=['=',$id];
            return $this->where($where)->select();
        }
    }

    /**
     * 商品分类信息编辑/添加
     * name:张平
     * @param $id 商品分类id/添加操作输入为0
     * @param $name 分类名
     * @param $parentId 上级id
     * @param $type 操作类型 0:编辑,1:添加下级分类
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function cateUpdate($id, $name, $parentId, $type)
    {
        $selectName = $this->where('name', $name)->find();
        //验证分类名是否唯一
        if ($selectName == null || $type==0) {
            $data['name'] = $name;
            $data['parent_id'] = $parentId;
            //判断该操作为编辑或添加,进行相应操作
            if ($type == 0) {
                $data = $this->where('id', $id)->update($data);
            } else {
                $data = $this->save($data);
            }
            //判断操作是否成功
            if ($data == 1) {
                $array['type'] = 1;
                //根据操作类型,返回相应提示
                if ($type == 0) {
                    $array['data'] = '编辑操作成功';
                } elseif ($type == 1) {
                    $array['data'] = '添加下级操作成功';
                } elseif ($type == 2) {
                    $array['data'] = '添加分类操作成功';
                }
            } else {
                $array['type'] = 0;
                //根据操作类型,返回相应提示
                if ($type == 0) {
                    $array['data'] = '编辑操作失败';
                } elseif ($type == 1) {
                    $array['data'] = '添加下级操作失败';
                } elseif ($type == 2) {
                    $array['data'] = '添加分类操作失败';
                }
            }
        } else {
            $array['type'] = 2;
            $array['data'] = '分类名唯一,该分类名已存在';
        }
        return $array;
    }

    /**
     * 返回所有下级分类
     * name:张平
     * @param $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function guodu($data)
    {
        $array = array();
        $array[] = $data;
        foreach ($data as $vo) {
            $kk = $this->brothers($vo['id']);
            if (count($kk) != 0) {
                $array[] = $kk;
                $aa = $this->guodu($kk);
                if (count($aa) != 0) {
                    foreach ($aa as $a) {
                        $oo = array_intersect($array, $aa);
                        if (count($oo) == 0) {
                            $array[] = $a;
                        } else {
                            continue;
                        }
                    }
                }
            } else {
                break;
            }
        }
        return $array;
    }



}