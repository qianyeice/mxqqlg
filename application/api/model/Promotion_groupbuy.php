<?php

namespace app\api\model;

use think\Model;

class Promotion_groupbuy extends Model
{
    /**
     *查询所有团购规则
     * @return array返回接口数据
     * 丁龙
     * 18.3.27 14:50
     */
    public function RuleQuery()
    {
        $cxjg = $this->field('rules,expires,explain,sort,max_num,title,id')->select()->toArray();
        //数据转换
        $arr = array();
        for ($i = 0; $i < count($cxjg); $i++) {
            $arr[] = json_decode($cxjg[$i]['rules']);
        }
        $arrtwo = array();
        for ($i = 0; $i < count($arr); $i++) {
            $hh = (array)$arr[$i];
            $arrtwo[] = '';
            for ($s = 0; $s < count($hh); $s++) {
                $count = count($hh);
                $hharr = (object)$arr[$i];
                if ($count != $s + 1) {
                    if ($s == 0) {
                        $arrtwo[count($arrtwo) - 1] .= ($count - 1) . "人团：";
                    }
                    $arrtwo[count($arrtwo) - 1] .= $s . "人" . ((100 - $hharr->{$s + 1}) != 100 ? (100 - $hharr->{$s + 1}) : '无') . "折,";
                } else {
                    $arrtwo[count($arrtwo) - 1] .= '满人团长：' . (100 - $hharr->leader) . "折,";
                }
            }
        }
        cache('GroupBuyingRules',$arrtwo);
        return $arrtwo;
}
}