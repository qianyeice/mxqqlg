<?php

namespace app\api\model;

use think\Model;

class Category extends Model
{
    function sele()
    {
        $items = $this
//          ->cache("moreTitle",7200)
            ->where('parent_id', 0)
            ->select();
//        $items = $this->gueilei($items);
//        $items = $this->digui($items);
        $array = [];
        if (count($items) > 0) {
            $array['type'] = 1;
            $array['lang'] = 'success';
            $array['data'] = $items;
        } else {
            $array['type'] = 0;
            $array['lang'] = 'faileds';
            $array['data'] = '';
        }
        return $array;
    }

    function gueilei($data)
    {
        $da = array();
        foreach ($data as $val) {
            $da[$val['parent_id']][] = $val;
        }
        return $da;
    }

    function digui($data, $pid = 0)
    {
        $d = '';
        if (isset($data[$pid])) {
            $d = $data[$pid];
            if (is_array($data[$pid])) {
                foreach ($data[$pid] as $key => $val) {
                    $s = $this->digui($data, $val['id']);
                    if (!empty($s)) {
                        $d[$key]['zi'] = $s;
                    }
                }
            }
        }
        return $d;
    }


}