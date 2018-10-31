<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 14:11
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;


/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 订单管理
 * Date: 2018/3/29
 * Time: 9:59
 */
class Orderdetails extends adminController
{
    function init()
    {
        //        实例化ViewInvoice
        $data = new ViewInvoice();
        $search = input('get.val');
        $tpye=input('get.type');
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 10;
//        判断get，val值是否存在，
//            搜索的值t
         $val = $data->order_search($search, $start, $limit,$tpye);
         $count = $val['data']['count'];
         unset($val['data']['count']);
//            exit;

        $this->assign('val', $val['data']);
        $this->assign('type', $tpye);
        $this->assign('count', $count);
        $this->assign('limit', $limit);
        return view();
    }


    /**
     * excel表格数据导出:数据准备
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function orderExport()
    {
        $data = new ViewInvoice();
        $type = input('type') != null ? input('type') : 0;
        $data = $data->order_management($type, 0, 100, true);

        if ($data['data']) {
            $obj = $data['data'];
            $excelData = array();
            foreach ($obj as $key => $v) {
                $data = array(
                    'sn' => "\t" . trim($v['sn']),
//                                'sku_name' => "\t".trim($v1['sku_name']),
//                                'sku_spec' => "\t".$specStr,
//                                'sku_price' => "\t".sprintf('%.2f', $v1['sku_price']),
//                                'real_price' => "\t".sprintf('%.2f', $v1['real_price']),
//                                'buy_nums' => "\t".trim($v1['buy_nums']),
                    'username' => "\t" . trim($v['username']),
                    'address_name' => "\t" . trim($v['address_name']),
                    'address_mobile' => "\t" . trim($v['address_mobile']),
//                    'address_detail' => "\t" . $v['address_detail'],
//                    'system_time' => "\t" . date('Y-m-d H:i', $v['order_time']),
                    'real_amount' => "\t" . sprintf('%.2f', $v['paid_amount']),
                    '_pay_type' => $v['pay_type'] == 1 ? '在线支付' : '货到付款',
                    'pay_sn' => "\t" . $v['pay_sn'],
                    'buy_type' => $v['groupbuy_id'] > 0 ? '团购购买' : '普通购买',
                );
                if ($v['status'] == 4) {
                    $data['_status'] = '创建订单';
                } elseif ($v['pay_status'] == 1) {
                    $data['_status'] = '已付款';
                } elseif ($v['status'] == 1) {
                    $data['_status'] = '已确认';
                } elseif ($v['status'] == 2) {
                    $data['_status'] = '已发货';
                } elseif ($v['finish_status'] == 2) {
                    $data['_status'] = '已完成';
                } elseif ($v['hd_type'] == 1) {
                    $data['_status'] = '已取消';
                } elseif ($v['hd_type'] == 2) {
                    $data['_status'] = '已回收';

                }
                $excelData[] = $data;
            }
            $header = array(
                'sn' => '订单号',
//            'sku_name' =>'商品名称',
//            'sku_spec' =>'商品规格',
//            'sku_price' =>'商品价格',
//            'real_price' =>'支付价格',
//            'buy_nums' =>'购买数量',
                'username' => '会员帐号',
                'address_name' => '收货人',
                'address_mobile' => '收货电话',
//                'address_detail' => '收货地址',
//                'system_time' => '下单时间',
                'real_amount' => '订单金额',
                '_pay_type' => '支付方式',
                'pay_sn' => '第三方支付流水号',
                'buy_type' => '购买类型',
                '_status' => '订单状态',
            );
            $name = '全部';
            switch ($type) {
                case 1:
                    $name = '待付款';
                    break;
                case 2:
                    $name = '待确认';
                    break;
                case 3:
                    $name = '待发货';
                    break;
                case 4:
                    $name = '已发货';
                    break;
                case 5:
                    $name = '已完成';
                    break;
                case 6:
                    $name = '已取消';
                    break;
                case 7:
                    $name = ' 已回收';
                    break;
                case 8:
                    $name = '昨日确认收货订单';
                    break;
            }
            $filename = $name . '订单 ' . date('Y-m-d H:i');
            $this->exportExcel($filename, $header, $excelData);
        } else {
            $return['type'] = 0;
            $return['data'] = '无可导出订单';
        }


    }


    /**
     * 数据导出
     * @param array $title   标题行名称
     * @param array $data   导出数据
     * @param string $fileName 文件名
     * @param string $savePath 保存路径
     * @param $type   是否下载  false--保存   true--下载
     * @return string   返回文件全路径
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    function exportExcel($title=array(), $data=array(), $fileName='', $savePath='./', $isDown=false){
        include '../../../vendor//Classes/PHPExcel.php';

        $obj = new PHPExcel();

        //横向单元格标识
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $obj->getActiveSheet(0)->setTitle('sheet名称');   //设置sheet名称
        $_row = 1;   //设置纵向单元格标识
        if($title){
            $_cnt = count($title);
            $obj->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格
            $obj->setActiveSheetIndex(0)->setCellValue('A'.$_row, '数据导出：'.date('Y-m-d H:i:s'));  //设置合并后的单元格内容
            $_row++;
            $i = 0;
            foreach($title AS $v){   //设置列标题
                $obj->setActiveSheetIndex(0)->setCellValue($cellName[$i].$_row, $v);
                $i++;
            }
            $_row++;
        }

        //填写数据
        if($data){
            $i = 0;
            foreach($data AS $_v){
                $j = 0;
                foreach($_v AS $_cell){
                    $obj->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell);
                    $j++;
                }
                $i++;
            }
        }

        //文件名处理
        if(!$fileName){
            $fileName = uniqid(time(),true);
        }

        $objWrite = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');

        if($isDown){   //网页下载
            header('pragma:public');
            header("Content-Disposition:attachment;filename=$fileName.xls");
            $objWrite->save('php://output');exit;
        }

        $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码
        $_savePath = $savePath.$_fileName.'.xlsx';
        $objWrite->save($_savePath);

        return $savePath.$fileName.'.xlsx';
    }
//商家表格导出模板
//    public function exportExcel($expTitle, $expCellName, $expTableData)
//    {
//        include_once '../../../vendor/Classes/PHPExcel/Writer/Excel2007.php';
//        include_once '../../../vendor/Classes/PHPExcel/IOFactory.php';
//        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称
//        $fileName = '网站商家信息表' . date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
//        $cellNum = count($expCellName);
//        $dataNum = count($expTableData);
//        $objPHPExcel = new PHPExcel();
//        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
//            'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
//            'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ',
//            'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV',
//            'AW', 'AX', 'AY', 'AZ');
//        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
//        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');
////合并单元格
//
//        $objPHPExcel->getActiveSheet()->setCellValue('A1',
//            '网站商家信息表')->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        for ($i = 0; $i < $cellNum; $i++) {
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
//        }
//        // Miscellaneous glyphs, UTF-8
//        for ($i = 0; $i < $dataNum; $i++) {
//            for ($j = 0; $j < $cellNum; $j++) {
//
//                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] .
//                    ($i + 3), " " . $expTableData[$i][$expCellName[$j][0]]);
//            }
//        }
//        ob_end_clean(); //清除缓冲区,避免乱码
//        header('pragma:public');
//        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
//        header("Content-Disposition:attachment;filename=$fileName.xls");
////attachment新窗口打印inline本窗口打印
//        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save('php://output');
//        exit;
//    }



    function output($begin = 0, $end = 0)
    {//导出商家信息Excel
        $xlsName = "User";
        $xlsCell = array(
            array('userid', '商家id'),
            array('groupid', '商家等级'),
            array('store_name', '店铺名称'),
            array('contact_name', '联系人'),
            array('phone', '手机'),
            array('email', '邮箱'),
            array('activity_count', '活动商品'),
            array('frozen_deposit', '冻结中保证金'),
            array('regdate', '注册时间'),
            array('loginnum', '登录次数'),
            array('lastdate', '最近登录'),
            array('id_number', '身份证号码'),
            array('name', '姓名'),
            array('qq', 'QQ'),);
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        if ($begin > 0) {
            $beginToday = $begin;
        }
        if ($end > 0) {
            $endToday = $end;
        }
        $dataNum = count($xlsData);
        for ($i = 0; $i < $dataNum; $i++) {
            if ($xlsData[$i][groupid] == '1') {
                $xlsData[$i][groupid] = '普通商家';
            } else if ($xlsData[$i][groupid] == '2') {
                $xlsData[$i][groupid] = '金牌商家';
            } else if ($xlsData[$i][groupid] == '3') {
                $xlsData[$i][groupid] = '白金商家';
            } else if ($xlsData[$i][groupid] == '4') {
                $xlsData[$i][groupid] = '钻石商家';
            }

            $rs = M('member_attesta')->where("userid= '" . $xlsData[$i]['userid'] . "'
 AND type = 'identity'")->getField('infos');
            $identity = string2array($rs);
            $xlsData[$i]['id_number'] = $identity['id_number'];
            $xlsData[$i]['name'] = $identity['name'];

            $xlsData[$i]['activity_count'] =
                M('product')->where(array('company_id' => $xlsData[$i]['userid']))->count();
        }
        $this->exportExcel($xlsName, $xlsCell, $xlsData);
    }


}