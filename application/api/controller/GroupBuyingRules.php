<?php

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Promotion_groupbuy;
use think\facade\Cache;


class GroupBuyingRules extends apiController
{
    /**
     * 团购规则、说明接口
     * @return arrayf 返回 团购规则、说明接口
     * 丁龙
     * 18.3.27 14:42
     */
    public function RuleDescription()
    {
        $jg = Cache::get('GroupBuyingRules');
        if ($jg) {
           return $this->apiReturn(1,'',$jg);
        } else {
            $mod = new Promotion_groupbuy();
            $cxjg=$mod->RuleQuery();
            return $this->apiReturn(1,'',$cxjg);
        }

    }

}