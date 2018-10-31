<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param $cxjg 传入数据
 * @return bool 返回数据或结果
 * 丁龙 18.3.20 17:31
 */
function ToArray($cxjg)
{
    if (count($cxjg) > 0) {
        return $cxjg->toArray();
    } else {
        return false;
    }
}


/**
 * 时间戳转换
 * 18.3.22 17:25
 * 丁龙
 * @param $data 传入数据
 * @param $arr 传入下标对照数组
 * @return mixed 返回修改后的数组
 */
function binToTime($data, $arr)
{
    for ($i = 0; $i < count($data); $i++) {
        for ($s = 0; $s < count($arr); $s++) {
            $data[$i][$arr[$s]] = date('Y-m-d', $data[$i][$arr[$s]]);
        }
    }
    return $data;
}



/**
 * 时间戳转换
 * 18.3.22 17:25
 * 胡焱
 * @param $data 传入数据
 * @param $arr 传入下标对照数组
 * @return mixed 返回修改后的数组
 */
function CinToTime($data, $arr)
{
    for ($i = 0; $i < count($data); $i++) {
        for ($s = 0; $s < count($arr); $s++) {
            $data[$i][$arr[$s]] = date('H:s:i', $data[$i][$arr[$s]]);
        }
    }
    return $data;
}
/**
 * 判定是否进行时间戳转换
 * 胡焱
 * @param $data 传入数据
 * @param $arr 传入下标对照数组
 * @return mixed 返回修改后的数组
 */
function typePd($data, $arr)
{
    if ($data['type'] == 1) {
        $data['data'] = CinToTime($data['data'], $arr);
        return $data;
    } else {
        return $data;
    }
}






/**
 * 时间戳 转换
 * time:17:35 18-3-22
 * author:陈明福
 * @param $data 待处理时间撮的数据包
 * @param $fields 需处理的字段
 * @return array 返回处理结果
 */
function TimeConversion($data, $fields)
{
    $array = array();
    foreach ($data as $k => $v) {
        if ($v["type"] != 0) {
            for ($i = 0; $i < count($fields); $i++) {
                $v["data"][$fields[$i]] = date("Y-m-d H:i:s", $v["data"][$fields[$i]]);
            }
        }
        $array[$k] = $v;
    }
    return $array;
}








/**
 * 判定是否进行时间戳转换
 * 18.3.22 17:25
 * 丁龙
 * @param $data 传入数据
 * @param $arr 传入下标对照数组
 * @return mixed 返回修改后的数组
 */
function typePdZero($data, $arr)
{
    if ($data['type'] == 1) {
        $data['data'] = binToTime($data['data'], $arr);
        return $data;
    } else {
        return $data;
    }
}


/**
 * 封装删除函数
 * @param $id删除ID
 * @param $delId删除ID字段名
 * @param $is$this
 * @return mixed
 */
function del($id, $delId, $is)
{
    $data = $is->where($delId, $id)->update(['is_display' => '0']);
    if ($data) {
        $array["type"] = 1;
        $array["lang"] = lang('success');
    } else {
        $array["type"] = 0;
        $array["lang"] = lang('noData');
    }
    return $array;
}

/**
 * 封装根据id，修改数据
 * @param $id 修改id
 * @param $data 修改数组
 * @param $dd 当前数据表对象$this
 * @return array
 */
function modify($id, $data, $dd)
{
    $data = $dd->where('id', $id)->update($data);
    $array = array();
    if ($data) {
        $array["type"] = 1;
        $array["lang"] = lang('success');
    } else {
        $array["type"] = 0;
        $array["lang"] = lang('noData');
    }
    return $array;
}
         //添加
function insert($data, $ben)
{
    $data = $ben->insert($data);
    $array = array();
    if ($data) {
        $array["type"] = 1;
        $array["lang"] = lang('success');
    } else {
        $array["type"] = 0;
        $array["lang"] = lang('noData');
    }
    return $array;
}
/**
 * 分页
 * @param $field 字段
 * @param $select 查询条件
 * @param $page 页数
 * @param $count
 * @param $object
 * @param $true
 * @return string
 */
function listPage($field, $select, $page, $count, $object,$true=true)
{
    if (is_object($object)) {
        $length = $object->field($field)->where($select)->group('id')->select();
        if($true){
            $asc='desc';
        }else{
            $asc='asc';
        }
        $data = $object->field($field)->where($select)->page($page, $count)->order('id', $asc)->group('id')->select();
    } else {
        $data = '传入参数类型错误!';
    }
    $data['count'] = count($length);
    return $data;
}
function listP($field, $select, $page, $count, $object,$true=true)
{
    if (is_object($object)) {
        $length = $object->field($field)->where($select)->group('id')->select();
        if($true){
            $asc='asc';
        }else{
            $asc='desc';
        }

        $data['data'] = $object->field($field)->where($select)->page($page, $count)->order('id', $asc)->group('id')->select();

    } else {
        $data = '传入参数类型错误!';
    }
    $data['count'] = count($length);
    return $data;
}

function isArray($data){
    if(is_array($data)){
        return 1;
    }else{
        return 0;
    }
}
function getDbId($dataSheet,$vals,$field,$val){
    db($dataSheet)->insert($vals);
    $data=db($dataSheet)->where($field,$val)->find();
    return $data['id'];
}
