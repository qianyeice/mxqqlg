<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Admin_iframe;

class AdminIframe extends adminController{
    /**
     * 首页
     * time：18-3-29 10:16
     * author张关燚
     * @return \think\response\View
     */
    public function home_home()
    {
        $api = new Admin_iframe();
        $data = $api->order();
        $refund = $api->refund();
        $goods = $api->goods_spu();
        $count = $api->finish_status();
        $member = $api->member();
        $today_login = $api->today_login();
        $sale = $api->sale();
        $month = $api->month();
        $year = $api->year();
        $concerns = $api->wechat_concerns();
        $unconcerns = $api->wechat_unconcerns();
        $yesday_mny = $api->yesterday_money();
        $proportion = $api->getproportion();
        $yesred = $api->getyesred();
        $todayred=$yesday_mny*($proportion/100)+$yesred;
        $this->assign('todayred',$todayred);
        $this->assign('yesday_mny',$yesday_mny);
        $this->assign('proportion',$proportion);
        $this->assign('yesred',$yesred);
        $this->assign('unconcerns',$unconcerns[0]['cc']);
        $this->assign('concerns',$concerns[0]['cc']);
        $this->assign('year',$year);
        $this->assign('month',$month);
        $this->assign('per_capita',$sale['per_capita']);
        $this->assign('sale',$sale['saleall']);
        $this->assign('today_login',$today_login[0]['cc']);
        $this->assign('member',$member[0]['cc']);
        $this->assign('count',$count[0]['count(*)']);
        $this->assign('Pending_deliver',$data['Pending_deliver']);
        $this->assign('Pending_payment',$data['Pending_payment']);
        $this->assign('Pending_evaluate',$data['Pending_evaluate']);
        $this->assign('confirm_status',$data['confirm_status']);
        $this->assign('goods',$refund['goods']);
        $this->assign('moneny',$refund['moneny']);
        $this->assign('status',$goods['status']);
        $this->assign('no_status',$goods['no_status']);
        $this->assign('number',$goods['number']);

        return view('admin_iframe/home_home');
        }
}