<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\10 0010
 * Time: 11:53
 */

namespace app\admin\model;

use think\Db;

class Distribution_management
{
    /**
     * 物流配送设置数据库存储
     * 2018 4 10 14:39白锦国
     */
    function adds($enabled, $name, $identif, $logo, $sort, $adds)
    {
        //操作时间;
        $systime = date("Y-m-d H:i:s");
        $datas = Db::table('delivery')->where('name', $name)->find();
        $sorts = Db::table('delivery')->where('sort', $sort)->find();
            if ($adds == 1) {
                if (count($datas) > 0) {
                    $array = lang('Existing_brand');
                } else {
                    if (count($sorts) > 0) {
                        $array = lang('Existing_sort');
                    } else {
                        $data = [
                            'name' => $name,
                            'identif' => $identif,
                            'enabled' => $enabled,
                            'logo' => 'http://p5od7vvyw.bkt.clouddn.com/'.$logo,
                            'sort' => $sort,
                            'systime' => $systime
                        ];
                        $daa = Db::name('delivery')->insert($data);
                        if ($daa) {
                            $array = lang('success_Jump');
                        } else {
                            $array = lang('success_fail');
                        }
                    }
                }

            } else {
                if ((count($sorts) > 0)&&($sorts['sort']!=$sort)) {
                    $array = lang('Existing_sort');
                } else {
                    $daa = Db::name('delivery')
                        ->where('id', $adds)
                        ->update([
                            'name' => $name,
                            'identif' => $identif,
                            'enabled' => $enabled,
                            'logo' => $logo,
                            'sort' => $sort,
                            'systime' => $systime
                        ]);
                    if ($daa) {
                        $array = lang('Editor_success');
                    } else {
                        $array = lang('Editor_fail');
                    }
                }
            }
        return $array . '<a href="?s=admin/distribution_logistics/index">点击返回</a>';
    }

    public function update($enabled,$name,$identif,$sort,$adds){

        $systime = date("Y-m-d H:i:s");
        $daa = Db::name('delivery')
            ->where('id', $adds)
            ->update([
                'name' => $name,
                'identif' => $identif,
                'enabled' => $enabled,
                'sort' => $sort,
                'systime' => $systime
            ]);
        return $daa;
    }
}